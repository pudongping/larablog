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

    public function __construct()
    {
        $this->menuRepository = \App::make('App\Repositories\Admin\Menu\MenusRepository');
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

}
