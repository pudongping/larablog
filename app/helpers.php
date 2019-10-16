<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019-10-15
 * Time: 14:22
 */

if (!function_exists('route_class')) {
    /**
     * 当前请求的路由名称转换为 CSS 类名称
     * example：当前路由名称为 tests.index，则会转换成 tests-index
     *
     * @return mixed
     */
    function route_class()
    {
        return str_replace('.', '-', Route::currentRouteName());
    }
}