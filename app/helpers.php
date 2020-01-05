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

if (! function_exists('http_get')) {
    /**
     * HTTP Get 请求数据
     *
     * @param $api  string  需要请求的 url
     * @param $query  array  请求参数数组
     * @return mixed
     */
    function http_get($api, $args)
    {
        $client = new \GuzzleHttp\Client;
        $query = http_build_query($args);
        $response = $client->get($api . '?' . $query);
        $result = json_decode($response->getBody(), true);
        return $result;
    }
}

if (! function_exists('html_2_markdown')) {
    /**
     * 将 HTML 文本转换为 Markdown 文本
     *
     * @param $html
     * @return string
     */
    function html_2_markdown($html)
    {
        $converter = new \League\HTMLToMarkdown\HtmlConverter();
        $markdown = $converter->convert($html);
        return $markdown;
    }
}

if (! function_exists('markdown_2_html')) {
    /**
     * 将 markdown 文本转换成 html 文本
     *
     * @param $markdown
     * @return string
     */
    function markdown_2_html($markdown)
    {
        $parsedown = new Parsedown();
        $parsedown->setSafeMode(true);
        $html = $parsedown->parse($markdown);
        return $html;
    }
}

if (! function_exists('html_table_2_markdown_table')) {
    /**
     * 将 html 表格标签转成 markdown 表格标签
     *
     * @param $theadAndTbody  表头和表体数据
     * @return string  具有 markdown 格式的表格数据
     */
    function html_table_2_markdown_table($theadAndTbody)
    {
        preg_match_all('/<thead>([\s\S]*?)<\/thead>/', $theadAndTbody, $matches1);

        // 判断当前字符串中是否含有表头信息
        if (empty($matches1[0])) return $theadAndTbody;
        // 表格头字符串
        $theads = $matches1[1][0];
        preg_match_all('/<th>([\s\S]*?)<\/th>/', $theads, $matches2);

        // markdown table title
        $theads = str_replace('<tr><th>', '', $theads);
        $theads = str_replace('</th><th>', ' | ', $theads);
        $theads = str_replace('</th></tr>', " \n ", $theads);

        // 表格头部数据数组
        $theadArr = $matches2[1];
        $tabletitle = '';
        for ($i = 0; $i < count($theadArr); $i++) {
            $tabletitle .= ' --- |';
        }
        $tabletitle = trim($tabletitle, '|') . " \n ";

        // 表格主体数据数组
        preg_match_all('/<tbody>([\s\S]*?)<\/tbody>/', $theadAndTbody, $matches3);

        // 如果当前表格只有表头数据，没有主体数据，则直接返回表头数据
        if (empty($matches3[0])) return $theads . $tabletitle;

        // 表格主体数据 html 字符串
        $tbodys = $matches3[1][0];
        $tbodys = str_replace('<tr><td>', '', $tbodys);
        $tbodys = str_replace('</td><td>', ' | ', $tbodys);
        $tbodys = str_replace('</td></tr>', " \n ", $tbodys);

        // 表头 + 分割线 + 表主体数据
        $tableMakrdown = $theads . $tabletitle . $tbodys;

        return $tableMakrdown;
    }
}

if (! function_exists('html_2_markdown_with_table')) {
    /**
     * 将 html 文本你转换成 markdown 文本，且表格标签也转换成 markdown 格式的表格
     *
     * @param $html  需要转换的 html 文本
     * @return string|void  纯 markdown 文本 | null
     */
    function html_2_markdown_with_table($html)
    {
        if (empty($html)) return;

        $markdown = html_2_markdown($html);

        // 以 <table> 标签或者 </table> 标签将 html 字符串分隔成数组
        $chars = preg_split('/<table>|<\/table>/', $markdown);
        if (empty($chars)) return $markdown;

        $mark = '';
        foreach ($chars as $item) {
            $mark .= html_table_2_markdown_table($item);
        }

        return $mark;
    }
}

if (! function_exists('site_setting')) {
    /**
     * 获取站点设置相关数据
     *
     * @param $key  站点设置字段
     * @param string $default  如果当前字段没有值，则以默认值填充
     * @param string $settingName  配置 key
     * @return mixed  站点字段对应值
     */
    function site_setting($key, $default = '', $settingName = 'site')
    {
        if (! config()->get($settingName)) {
            // 获取站点设置相关数据
            $sitesData = app('App\Repositories\Admin\Setting\SitesRepository')->edit();
            // 将站点设置添加到应用程序配置中
            config()->set($settingName, $sitesData);
        }
        // 获取站点设置相关数据并提供默认值
        return config()->get($settingName . '.' . $key, $default);
    }
}

if (! function_exists('user_log')) {
    /**
     * 用户操作日志
     *
     * @param null $msg
     */
    function user_log($msg = null)
    {
        $user = Auth::user();

        if (empty($user)) {
            $uid = \App\Models\Auth\User::SYSADMIN_ID;
        } else {
            $uid = $user->id;
        }

        $log = new \App\Models\Admin\Setting\Log();
        $log->user_id = $uid;
        $log->client_ip = request()->ip();
        // JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES = 256 + 64 = 320
        $log->header = json_encode(request()->header(), 320);
        $log->description = $msg;
        $log->save();
    }
}

if (! function_exists('batchUpdate')) {
    /**
     * $where = [ 'id' => [180, 181, 182, 183], 'user_id' => [5, 15, 11, 1]];
     * $needUpdateFields = [ 'view_count' => [11, 22, 33, 44], 'updated_at' => ['2019-11-06 06:44:58', '2019-11-30 19:59:34', '2019-11-05 11:58:41', '2019-12-13 01:27:59']];
     *
     * 最终执行的 sql 语句如下所示
     *
     * UPDATE articles SET
     * view_count = CASE
     * WHEN id = 183 AND user_id = 1 THEN 44
     * WHEN id = 182 AND user_id = 11 THEN 33
     * WHEN id = 181 AND user_id = 15 THEN 22
     * WHEN id = 180 AND user_id = 5 THEN 11
     * ELSE view_count END,
     * updated_at = CASE
     * WHEN id = 183 AND user_id = 1 THEN '2019-12-13 01:27:59'
     * WHEN id = 182 AND user_id = 11 THEN '2019-11-05 11:58:41'
     * WHEN id = 181 AND user_id = 15 THEN '2019-11-30 19:59:34'
     * WHEN id = 180 AND user_id = 5 THEN '2019-11-06 06:44:58'
     * ELSE updated_at END
     *
     *
     * 批量更新数据
     *
     * @param string $tableName  需要更新的表名称
     * @param array $where  需要更新的条件
     * @param array $needUpdateFields  需要更新的字段
     * @return bool|int  更新数据的条数
     */
    function batchUpdate(string $tableName, array $where, array $needUpdateFields)
    {

        if (empty($where) || empty($needUpdateFields)) return false;
        // 第一个条件数组的值
        $firstWhere = $where[array_key_first($where)];
        // 第一个条件数组的值的总数量
        $whereFirstValCount = count($firstWhere);
        // 需要更新的第一个字段的值的总数量
        $needUpdateFieldsValCount = count($needUpdateFields[array_key_first($needUpdateFields)]);
        if ($whereFirstValCount !== $needUpdateFieldsValCount) return false;
        // 所有的条件字段数组
        $whereKeys = array_keys($where);

        // 绑定参数
        $building = [];

//        $whereArr = [
//          0 => "id = 180 AND ",
//          1 => "user_id = 5 AND ",
//          2 => "id = 181 AND ",
//          3 => "user_id = 15 AND ",
//          4 => "id = 182 AND ",
//          5 => "user_id = 11 AND ",
//          6 => "id = 183 AND ",
//          7 => "user_id = 1 AND ",
//        ]
        $whereArr = [];
        $whereBuilding = [];
        foreach ($firstWhere as $k => $v) {
            foreach ($whereKeys as $whereKey) {
//                $whereArr[] = "{$whereKey} = {$where[$whereKey][$k]} AND ";
                $whereArr[] = "{$whereKey} = ? AND ";
                $whereBuilding[] = $where[$whereKey][$k];
            }
        }

//        $whereArray = [
//            0 => "id = 180 AND user_id = 5",
//            1 => "id = 181 AND user_id = 15",
//            2 => "id = 182 AND user_id = 11",
//            3 => "id = 183 AND user_id = 1",
//        ]
        $whereArrChunck = array_chunk($whereArr, count($whereKeys));
        $whereBuildingChunck = array_chunk($whereBuilding, count($whereKeys));

        $whereArray = [];
        foreach ($whereArrChunck as $val) {
            $valStr = '';
            foreach ($val as $vv) {
                $valStr .= $vv;
            }
            // 去除掉后面的 AND 字符及空格
            $whereArray[] = rtrim($valStr, "AND ");
        }

        // 需要更新的字段数组
        $needUpdateFieldsKeys = array_keys($needUpdateFields);

        // 拼接 sql 语句
        $sqlStr = '';
        foreach ($needUpdateFieldsKeys as $needUpdateFieldsKey) {
            $str = '';
            foreach ($whereArray as $kk => $vv) {
//                $str .= ' WHEN ' . $vv . ' THEN ' . $needUpdateFields[$needUpdateFieldsKey][$kk];
                $str .= ' WHEN ' . $vv . ' THEN ? ';
                // 合并需要绑定的参数
                $building[] = array_merge($whereBuildingChunck[$kk], [$needUpdateFields[$needUpdateFieldsKey][$kk]]);
            }
            $sqlStr .= $needUpdateFieldsKey . ' = CASE ' . $str . ' ELSE ' . $needUpdateFieldsKey . ' END, ';
        }

        // 去除掉后面的逗号及空格
        $sqlStr = rtrim($sqlStr, ', ');

        $tblSql = 'UPDATE ' . $tableName . ' SET ';

        $tblSql = $tblSql . $sqlStr;

        $building = array_reduce($building,"array_merge",array());
//        return [$tblSql, $building];
        return \DB::update($tblSql, $building);
    }
}
