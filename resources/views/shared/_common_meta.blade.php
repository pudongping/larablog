<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="description" content="@yield('description', site_setting('seo_description', '个人博客'))" />
<meta name="author" content="@yield('author', site_setting('founder_nickname'))">
<meta name="keyword" content="@yield('keyword', site_setting('seo_keyword', 'laravel,php,phper,coder,博客，开发者讨论'))" />

<!-- CSRF Token -->
{{-- 方便前端的 JavaScript 脚本获取 CSRF 令牌 --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title', site_setting('founder_nickname')) - {{ site_setting('site_name') }}</title>
