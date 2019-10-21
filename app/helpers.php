<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019-10-15
 * Time: 14:22
 */

if (! function_exists('route_class')) {
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

if (! function_exists('make_excerpt')) {
    /**
     * 生成文章的摘录
     *
     * @param $value  需要截取的原字符串
     * @param int $length  截取的长度
     * @return mixed  去除 HTML 和 PHP 标记并按照指定长度截取后的字符串
     */
    function make_excerpt($value, $length = 200)
    {
        $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
        return Str::limit($excerpt, $length);
    }
}