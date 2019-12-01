<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/12/1
 * Time: 14:47
 */

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use App\Models\Auth\User;
use App\Models\Portal\Article\Article;
use App\Models\Portal\Article\Reply;

class DashboardRepository extends BaseRepository
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function root($request)
    {
        $totalCount = $this->totalCount();  // 四个小方块
        $articleCount = $this->articleCountStyle($request);  // 文章统计折线图
        $tagForArticleCount = $this->tagForArticleCount();  // 分类统计环形图
        $categoryForArticleCount = $this->categoryForArticleCount();  // 标签统计柱状图
        $activeUserForArticleCount = $this->activeUserForArticleCount();  // 活跃用户发表文章数占比

        return array_merge($totalCount,
            $articleCount,
            $tagForArticleCount,
            $categoryForArticleCount,
            $activeUserForArticleCount);
    }

    /**
     * 控制面板总数统计
     *
     * @return array
     */
    public function totalCount()
    {
        $userTotal = User::all()->count() ? number_format(User::all()->count()) : 0;
        $articlesAll = Article::all()->count();
        $articleTotal = $articlesAll ? number_format($articlesAll) : 0;
        $replyTotal = Reply::all()->count() ? number_format(Reply::all()->count()) : 0;

        // 查询出有评论的文章总数
        $articleReplyCount = Reply::select(\DB::raw('count(DISTINCT article_id) as article_reply_count'))->first()->article_reply_count;
        $replyPer = $articleTotal ? ceil(($articleReplyCount / $articlesAll) * 100) : 0;  // 计算文章回复率 = 有评论文章总数 / 文章总数

        return compact('userTotal', 'articleTotal', 'replyPer', 'replyTotal');
    }

    /**
     * 文章统计数据
     *
     * @param $request
     * @return array
     */
    public function articleCountStyle($request)
    {
        $style = $request->article_style ? intval($request->article_style) : 0;
        // 根据指定时间跨度查询
        $timeFormat = $this->choiceTimeStyle($style);

        $articleCount = Article::select(\DB::raw("DATE_FORMAT(created_at, {$timeFormat}) as time, COUNT(id) as count"))
            ->groupBy(\DB::raw("DATE_FORMAT(created_at, {$timeFormat})"))
            ->orderBy(\DB::raw("DATE_FORMAT(created_at, {$timeFormat})"))
            ->get()
            ->toArray();

        $lineTime = array_column($articleCount, 'time') ?: [];
        $lineCount = array_column($articleCount, 'count') ?: [];

        return compact('lineTime', 'lineCount');
    }

    /**
     * 选择以何种时间方式做间隔
     *
     * @param int $style  需要的时间间隔的标识
     * @return string  数据库中需要的时间查询格式
     */
    private function choiceTimeStyle(int $style) : string
    {
        switch ($style) {
            case 0:
                $timeFormat = '"%Y-%m-%d"';  // 以天为基数间隔
                break;
            case 1:
                $timeFormat = '"%Y-%m"';  // 以月为基数间隔
                break;
            case 2:
                $timeFormat = '"%Y"';  // 以年为基数间隔
                break;
            default:
                $timeFormat = '"%Y-%m"';  // 默认以月为基数间隔
                break;
        }

        return $timeFormat;
    }

    /**
     * 统计每个标签对应文章数
     *
     * @return array
     */
    public function tagForArticleCount()
    {
        $fields = [
            'A.tag_id as id',
            'A.article_count as article_count',
            'T.name as name',
            'T.btn_class as btn_class'
        ];

        $sub = \DB::table('article_tag_pivot')
            ->selectRaw('tag_id, COUNT(article_id) as article_count')
            ->groupBy('tag_id')
            ->toSql();

        $data = \DB::table(\DB::raw("({$sub}) as A"))
            ->select($fields)
            ->leftJoin('tags as T', 'A.tag_id', '=', 'T.id')
            ->get()
            ->toArray();

        $tagData = array_map(function ($n) {
            return (array)$n;
        }, $data);

        $tagNames = array_column($tagData, 'name');
        $tagArticleCount = array_column($tagData, 'article_count');

        return compact('tagNames', 'tagArticleCount');
    }

    /**
     * 统计每个分类对应文章数
     *
     * @return array
     */
    public function categoryForArticleCount()
    {
        $fields = [
            'A.category_id as category_id',
            'A.article_count as article_count',
            'C.name as name',
        ];

        $sub = \DB::table('articles')
            ->selectRaw('category_id, COUNT(id) as article_count')
            ->groupBy('category_id')
            ->toSql();

        $data = \DB::table(\DB::raw("({$sub}) as A"))
            ->select($fields)
            ->leftJoin('categories as C', 'A.category_id', '=', 'C.id')
            ->get()
            ->toArray();

        $tagData = array_map(function ($n) {
            return (array)$n;
        }, $data);

        $categoryNames = array_column($tagData, 'name');
        $categoryArticleCount = array_column($tagData, 'article_count');
        $categoryColor = ['#4e73df', '#1cc88a', '#36b9cc', '#2d8cf0', '#19be6b', '#5cadff', '#ed4014', '#2b85e4', '#2db7f5', '#515a6e', '#ff9900'];

        return compact('categoryNames', 'categoryArticleCount', 'categoryColor');
    }

    /**
     * 统计活跃用户发表文章数
     *
     * @return array
     */
    public function activeUserForArticleCount()
    {
        // 只取前 5 位活跃用户
        $activeUser = $this->user->getActiveUsersFromCache()
            ->slice(0, 5)
            ->pluck('name', 'id')
            ->toArray();
        // 活跃用户的 id 数组
        $userIds = array_keys($activeUser);

        $userForArticleCount = \DB::table('articles')
            ->select(\DB::raw('user_id, COUNT(id) as article_count'))
            ->whereIn('user_id', $userIds)
            ->groupBy('user_id')
            ->get();

        $articles = Article::all()->count();
        $data = [];
        $item = [];
        // 背景样式
        $colorStyle = ['bg-danger', 'bg-warning', '', 'bg-info', 'bg-success'];
        foreach ($userForArticleCount as $userKey => $userItem) {
            $item['user_id'] = $userItem->user_id;
            $item['name'] = $activeUser[$userItem->user_id];
            $item['article_per'] = $articles ? ceil((($userItem->article_count) / $articles) * 100) : 0;
            $item['bg_cls'] = $colorStyle[$userKey];
            $data[] = $item;
        }

        return ['activeUserForArticleCount' => $data];
    }

}
