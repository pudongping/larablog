<?php
/**
 * 翻译处理器
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019-10-23
 * Time: 14:11
 */

namespace App\Handlers;

use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler
{

    // 需要翻译的语言
    const FROM_LANG = 'zh';
    // 期待翻译成的语言
    const TO_LANG = 'en';


    public function translate($text, $from = self::FROM_LANG, $to = self::TO_LANG)
    {
        $api = \ConstCustom::BAIDU_TRANSLATE_API;
        $appid = config('services.baidu_translate.appid');
        $key = config('services.baidu_translate.key');
        $salt = time();

        // 如果没有配置百度翻译，直接使用兼容的翻译方案
        if (empty($appid) || empty($key)) {
            return $this->pinyin($text);
        }

        // 生成签名
        $sign = $this->buildSign($text, $appid, $salt, $key);

        // 请求百度翻译 api 必要参数
        $args = [
            'q'     => $text,
            'from'  => $from,
            'to'    => $to,
            'appid' => $appid,
            'salt'  => $salt,
            'sign'  => $sign
        ];

        // 发送 HTTP Get 请求
        $result = http_get($api, $args);

        /**
         * 返回成功后的结果如下
         array:3 [▼
            "from" => "zh"
            "to" => "en"
            "trans_result" => array:1 [▼
                0 => array:2 [▼
                "src" => "我是番茄炖土豆"
                "dst" => "I'm tomato stewed potato"
                ]
            ]
        ]
         */

        // 尝试获取翻译后的结果
        if (isset($result['trans_result'][0]['dst'])) {
            // \Str::slug() 默认以 「-」 分割字符串
            return \Str::slug($result['trans_result'][0]['dst']);
        } else {
            // 如果百度翻译没有结果，使用拼音作为后备计划
            return $this->pinyin($text);
        }

    }

    /**
     * 签名生成方法
     *
     * @link  http://api.fanyi.baidu.com/api/trans/product/desktop?req=developer
     * @param $query  string  请求翻译query （需UTF-8编码） eg：文章标题
     * @param $appID  string  开发者 APP ID （需申请）
     * @param $salt  string  随机数
     * @param $secKey  string  开发者密钥 （需申请）
     * @return string  经过 MD5 加密后的 32 位小写的 sign
     */
    public function buildSign($query, $appID, $salt, $secKey)
    {
        // 按照 『appid+q+salt+密钥』 排列
        $str = $appID . $query . $salt . $secKey;
        return md5($str);
    }

    /**
     * 汉字转拼音（默认以中划线 「-」 分割）
     *
     * @param $text  string  需要转换成拼音的文字
     * @return mixed  string  以中划线连接的拼音
     */
    public function pinyin($text)
    {
        return \Str::slug(app(Pinyin::class)->permalink($text));
    }





}
