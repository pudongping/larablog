<?php
/**
 * 常量配置信息
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 2021/3/23
 * Time: 17:59
 */

namespace App\Support;

class ConstCustom
{

    /**
     * 默认分页显示数为 20
     */
    const PAGE_NUM = 20;

    /**
     * 百度翻译 api 链接地址
     */
    const BAIDU_TRANSLATE_API = 'http://api.fanyi.baidu.com/api/trans/vip/translate';

    /**
     * 站点设置文件存放路径
     */
    const SITE_PATH = 'administrator_settings';

    /**
     * 站点设置文件名称
     */
    const SITE_FILE_NAME = 'site.json';

}
