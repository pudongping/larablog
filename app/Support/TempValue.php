<?php
/**
 * 保存临时变量
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/15
 * Time: 23:00
 */

namespace App\Support;


class TempValue
{

    /**
     * 菜单
     *
     * @var $menu
     */
    public static $menu;

    /**
     * 当前登录用户
     *
     * @var $currentUser
     */
    public static $currentUser;

    /**
     * 是否调试
     *
     * @var $debug
     */
    public static $debug;

    /**
     * HTTP 请求方式
     *
     * @var $httpMethod
     */
    public static $httpMethod;

    /**
     * 控制器
     *
     * @var $controller;
     */
    public static $controller;

    /**
     * 方法
     *
     * @var $action
     */
    public static $action;

    /**
     * nopage 指定不分页
     *
     * @var $nopage
     */
    public static $nopage;

    /**
     * 当前页码
     *
     * @var $page
     */
    public static $page;

    /**
     * 分页每页显示数量
     *
     * @var $perPage
     */
    public static $perPage;

    /**
     * @var
     */
    public static $orderBy;

    /**
     * 「内存缓存」
     *
     * @var array
     */
    public static $cache = [];

    /**
     * 设置「内存缓存」
     *
     * @param $key  缓存键名
     * @param $value  缓存值
     * @param null $group  支持设置多组
     * @return bool
     */
    public static function setCache($key, $value, $group = null)
    {
        if (!empty($group)) {
            if (!isset(self::$cache[$group])) {
                self::$cache[$group] = [];
            }
            self::$cache[$group][$key] = $value;
        } else {
            self::$cache[$key] = $value;
        }
        return true;
    }

    /**
     * 获取「内存缓存」
     *
     * @param $key  被设置的缓存键名
     * @param null $group  被设置的缓存组名称
     * @return bool|mixed 取不到被设置的缓存值则为 false，否则返回被设置的缓存值
     */
    public static function getCache($key, $group = null)
    {
        if (!empty($group)) {
            if (!isset(self::$cache[$group])) {
                return false;
            }
            if (!isset(self::$cache[$group][$key])) {
                return false;
            }
            return self::$cache[$group][$key];
        } else {
            if (!isset(self::$cache[$key])) {
                return false;
            }
            return self::$cache[$key];
        }
    }

}