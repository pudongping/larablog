<?php
/**
 * http 输出
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019-10-16
 * Time: 14:12
 */

namespace App\Support;


class Response
{

    /**
     * 错误号
     *
     * @var int
     */
    public $code = 0;

    /**
     * 提示信息
     *
     * @var
     */
    public $msg;

    /**
     * 异常
     *
     * @var
     */
    public $exception;

    /**
     * 数据
     *
     * @var
     */
    public $data;

    /**
     * 元信息
     *
     * @var array
     */
    public $meta = [];

    /**
     * 错误提示详情信息
     *
     * @var
     */
    public $detail;

    /**
     * 时间
     *
     * @var
     */
    public $time;

    /**
     * transformer 的名称
     *
     * @var
     */
    public $transformerName;

    /**
     * 头部代码
     *
     * @var
     */
    public $headerCode;

    /**
     * 输出内容
     *
     * @var
     */
    private $_output;

    protected $menuRepository;
    protected $categoriesRepository;
    protected $user;
    protected $linksRepository;
    protected $tagsRepository;

    public function __construct()
    {
        $this->menuRepository = \App::make('App\Repositories\Admin\Menu\MenusRepository');
        $this->categoriesRepository = \App::make('App\Repositories\Portal\Article\CategoriesRepository');
        $this->user = \App::make('App\Models\Auth\User');
        $this->linksRepository = \App::make('App\Repositories\Admin\Setting\LinksRepository');
        $this->tagsRepository = \App::make('App\Repositories\Portal\Article\TagsRepository');
    }

    /**
     * 添加后台菜单
     *
     * @param null $menu
     */
    public function setMenu($menu = null)
    {
        if (is_null($menu)) {
            $menu = $this->menuRepository->menusTree();
        }

        $this->addMeta(['menusTree' => $menu]);
    }

    /**
     * 门户头部添加文章分类
     *
     * @param null $categories
     */
    public function setCategories($categories = null)
    {
        if (is_null($categories)) {
            $categories = $this->categoriesRepository->getAllCategories();
        }

        $this->addMeta(['allCategories' => $categories]);
    }

    /**
     * 门户右侧栏添加活跃用户
     *
     * @param null $activeUsers
     */
    public function setActiveUsers($activeUsers = null)
    {
        if (is_null($activeUsers)) {
            $activeUsers = $this->user->getActiveUsersFromCache();
        }

        $this->addMeta(['activeUsers' => $activeUsers]);
    }

    /**
     * 门户右侧栏添加资源推荐
     *
     * @param null $links
     */
    public function setLinks($links = null)
    {
        if (is_null($links)) {
            $links = $this->linksRepository->getAllLinksInCache();
        }

        $this->addMeta(['links' => $links]);
    }

    /**
     * 门户右侧栏添加标签云
     *
     * @param null $tags
     */
    public function setTags($tags = null)
    {
        if (is_null($tags)) {
            $tags = $this->tagsRepository->getAllTagsInCache();
        }

        $this->addMeta(['tags' => $tags]);
    }

    /**
     * 添加元数据
     *
     * @param array $value
     */
    public function addMeta(array $value)
    {
        $this->meta = array_merge($this->meta, $value);
    }

    /**
     * 获取后台通用变量
     *
     * @return array
     */
    public function getAdminMeta()
    {
        $this->setMenu();
        return $this->meta;
    }

    /**
     * 获取门户通用变量
     *
     * @return array
     */
    public function getPortalMeta()
    {
        $this->setCategories();  // 文章分类
        $this->setActiveUsers();  // 活跃用户排名
        $this->setLinks();  // 资源推荐
        $this->setTags();  // 标签云
        return $this->meta;
    }

}
