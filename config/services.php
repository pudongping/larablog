<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // 百度翻译 「APP ID」 和 「密钥」 key
    'baidu_translate' => [
        'appid' => env('BAIDU_TRANSLATE_APPID'),
        'key'   => env('BAIDU_TRANSLATE_KEY'),
    ],

    // Github 授权登录 「Client ID」 和 「Client Secret」
    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),  // Github 客户端授权 ID
        'client_secret' => env('GITHUB_CLIENT_SECRET'),  // Github 客户端授权密钥
        'redirect' => '/login/github/callback',  // 授权回调链接 如果 redirect 配置项包含的是相对路径，系统会自动将其转化为完整 URL
    ],

];
