<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/20
 * Time: 22:37
 */

namespace App\Repositories\Portal\Article;

use App\Handlers\ImageUploadHandler;
use App\Repositories\BaseRepository;
use App\Models\Portal\Article\Article;
use App\Models\Portal\Article\Category;
use App\Models\Portal\Article\Tag;
use Carbon\Carbon;

class ArticlesRepository extends BaseRepository
{

    protected $model;
    protected $imageUploadHandler;

    public function __construct(
        Article $article,
        ImageUploadHandler $imageUploadHandler
    ) {
        $this->model = $article;
        $this->imageUploadHandler = $imageUploadHandler;
    }

    /**
     * 文章列表
     *
     * @param $request  请求实例
     * @return mixed
     */
    public function index($request)
    {

        $search = $request->search;

        // 使用了「Article」模型中的排序规则动态作用域
        $model = Article::withOrder($request->order);

        $model = $model->where(function ($query) use ($search) {
            if (! empty($search)) {
                $query->orWhere('title', 'like', '%' . $search . '%');  // 文章标题
                $query->orWhere('body', 'like', '%' . $search . '%');  // 文章内容
            }
        });

        // 分页实例
        $paginator = $this->usePage($model);
        // 分页后的数据
        $currentArticle = $paginator->getCollection()->toArray();
        // 含有最新访问量的文章数据
        $articles = $this->replaceViewCountInRDS($currentArticle);
        // 因为分页会自动追加 page 参数，因此需要先去除掉 page 参数，然后将其他的参数追加到 url 中
        $pageLinks = $paginator->appends($request->except('page'))->render();

        return compact('articles', 'pageLinks');
    }

    /**
     * 新建文章-保存数据
     *
     * @param $request  请求实例
     * @return object  已保存的文章对象
     */
    public function storage($request)
    {
        $input = $request->only(['title', 'category_id']);
        $input['body'] = $this->getBody($request);
        $input['user_id'] = \Auth::id();
        \DB::beginTransaction();
        try {
            // 保存文章
            $article = $this->store($input);
            // 同步标签
            $article->updateTags($request->tag_id);
            \DB::commit();
            return $article;
        } catch (\Exception $exception) {
            \DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * 「Simditor」富文本编辑器上传图片
     *
     * @link  https://simditor.tower.im//docs/doc-config.html
     * @param $request  请求实例
     * @return array  按照 simditor 文档要求返回的数据格式
     */
    public function uploadImage($request)
    {
        $data = [
            'success'   => false,
            'msg'       => '上传失败！',
            'file_path' => ''
        ];

        // 判断是否有上传文件
        if ($file = $request->image) {
            $result = $this->imageUploadHandler->save($file, 'articles', \Auth::id(), 'image', 1024);
            if ($result) {
                $data['success'] = true;
                $data['msg'] = '上传成功！';
                $data['file_path'] = $result['path']; // 带 url 的绝对路径
            }
        }

        return $data;
    }

    /**
     * 「simplemde」 markdown 编辑器拖拽上传图片
     *
     * @param $request  请求实例
     * @return array  参照 node_modules/inline-attachment/demo/upload_attachment.php 返回的格式
     */
    public function uploadMarkdownImage($request)
    {
        $data = [
            'filename' => '',
            'error'    => '上传失败！'
        ];

        if ($file = $request->file) {
            $result = $this->imageUploadHandler->save($file, 'articles', \Auth::id(), 'file', 1024);
            if ($result) {
                $data['error'] = '上传成功！';
                $data['filename'] = $result['path']; // 必须为带 url 的绝对路径
            }
        }

        return $data;
    }

    /**
     * 编辑文章-数据处理
     *
     * @param $request  请求实例
     * @return mixed  当前更新文章实例
     */
    public function modify($request)
    {
        $input = $request->only('title', 'category_id');
        $input['body'] = $this->getBody($request);

        \DB::beginTransaction();
        try {
            $article = $this->update($request->id, $input);
            $article->updateTags($request->tag_id);
            \DB::commit();
            return $article;
        } catch (\Exception $exception) {
            \DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     *  获取文章内容
     *
     * @param $request  当前请求实例
     * @return string  html 格式的文章内容
     * @throws \Exception
     */
    private function getBody($request)
    {
        // 判断当前提交的文章是否是 markdown 文本内容
        if ($request->is_markdown) {
            $html = markdown_2_html($request->markdownbody);
        } else {
            $html = $request->htmlbody;
        }

        if (empty(trim($html))) {
            throw new \Exception('文章内容不能为空');
        }

        return $html;
    }

    /**
     * 后台管理-文章列表
     *
     * @param $request
     * @return array
     */
    public function adminIndex($request)
    {
        $search = $request->search;  // 关键词
        $categoryId = $request->category_id;  // 分类 id
        $tagId = $request->tag_id;  // 标签 id

        $where = [];
        $tbl = 'articles';
        $userTbl = 'users';

        if (! is_null($categoryId)) {
            $where[] = ['category_id', '=', $categoryId];
        }

        $fields = ["{$tbl}.*"];

        $model = $this->model->select($fields)->with('category', 'user', 'tags')->where($where);

        if (! is_null($tagId)) {
            // 先取出关联表中符合标签的所有文章 id 数组
            $articleIds = \DB::table('article_tag_pivot')->where('tag_id', $tagId)->get()->pluck('article_id')->toArray();
            $model = $model->whereIn("{$tbl}.id", array_unique($articleIds));
        }

        if (! empty($search)) {
            $model = $model->leftJoin("{$userTbl} as U", "{$tbl}.user_id", '=', 'U.id')
                ->where(function ($query) use ($search, $tbl) {
                    $query->orWhere("{$tbl}.title", 'like', '%' . $search . '%');  // 文章标题
                    $query->orWhere("{$tbl}.excerpt", 'like', '%' . $search . '%');  // 文章摘要
                    $query->orWhere('U.name', 'like', '%' . $search . '%');  // 用户昵称
                });
        }

//        if (false !== ($between = $this->searchTime($request))) {
//            $model = $model->whereBetween("{$tbl}.created_at", $between);
//        }

        $articles = $this->usePage($model, "{$tbl}.id");
        $categories = Category::all();
        $tags = Tag::all();

        return compact('articles', 'categories', 'tags');

    }

    /**
     * 将 redis 中的文章访问量拼接到文章数据中
     *
     * @param $articles  array  文章数据
     * @return mixed
     */
    public function replaceViewCountInRDS(array $articles)
    {
        if (empty($articles)) return $articles;

        // 取出所有存在 redis 中的文章访问量
        $viewCountInRDS = \Redis::hGetAll($this->model->getAtlViewHashPrefix());

        foreach ($articles as &$article) {
            // 先从 redis 中取值，如果 redis 中没有值，则以数据库中的值为准
            $article['view_count'] = $viewCountInRDS[$article['id']] ?? $article['view_count'];
            // 将时间格式化为 carbon 对象
            $article['updated_at'] = Carbon::parse($article['updated_at']);
        }

        return $articles;
    }



}
