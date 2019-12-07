# 基于 Laravel6.x 构建的博客应用，支持 Markdown，支持图片拖拽上传，基于 RBAC 权限管理系统

首页

![首页.png](https://upload-images.jianshu.io/upload_images/14623749-f32ef21d42b702c2.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

基于 RBAC 的权限管理后台，Dashboard 页面统计了用户总数、文章发布总数、评论率、评论总数、文章支持按天、按月、按年统计、支持按分类、按标签统计……

![后台首页.png](https://upload-images.jianshu.io/upload_images/14623749-74c132c165d20aae.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

登录页面

![登录页面.png](https://upload-images.jianshu.io/upload_images/14623749-93885ee50879719e.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

注册页面

![注册页面.png](https://upload-images.jianshu.io/upload_images/14623749-a883ff409344f8c1.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

支持 GitHub 授权登录

![GitHub授权登录页面.png](https://upload-images.jianshu.io/upload_images/14623749-f87b0926873bdfd0.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

支持邮箱重置密码

![重置密码页面.png](https://upload-images.jianshu.io/upload_images/14623749-11fbe50ac341bf7e.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

同时兼容 HTML 编辑器和 Markdown 编辑器

![富文本编辑器.png](https://upload-images.jianshu.io/upload_images/14623749-537e03bdc254a951.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![markdown 编辑器.png](https://upload-images.jianshu.io/upload_images/14623749-c1c8018845d986ba.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

Markdown 编辑器：支持拖拽粘贴上传图片、预览、全屏、分屏预览 

![markdown 编辑器预览效果.png](https://upload-images.jianshu.io/upload_images/14623749-092682db5e3cec7a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![后台用户.png](https://upload-images.jianshu.io/upload_images/14623749-9db84df41d52c0a3.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

## 项目概述
- 项目名称：larablog
- 项目简介：基于 laravel6.x 开发的博客项目
- 访问地址：[https://www.drling.xin/](https://www.drling.xin/)


## 功能如下
- 用户认证 —— 注册、登录、退出；
- 个人中心 —— 用户个人中心，编辑资料；
- 用户授权 —— 作者才能删除自己的内容；
- 上传图片 —— 修改头像和编辑文章时上传图片；
- 表单验证 —— 使用表单验证类；
- 重置密码 —— 通过邮箱找回密码
- 文章支持分类、多标签；
- 编辑文章支持 markdown 编辑器 、html 编辑器；
- markdown 编辑器支持拖拽上传图片、语法高亮、预览、全屏、分屏实时预览；
- 文章发布时自动 Slug 翻译，支持使用队列方式以提高响应；
- 站点『活跃用户』计算，一小时计算一次；
- 多角色权限管理 —— 允许站长，管理员权限的存在；
- 后台管理 —— 基于 RBAC 后台数据模型管理；
- 邮件通知 —— 发送新回复邮件通知，队列发送邮件；
- 站内通知 —— 文章有新回复；
- 自定义 Artisan 命令行 —— 自定义活跃用户计算命令；
- 自定义 Trait —— 活跃用户的业务逻辑实现；
- 自定义中间件 —— 记录用户的最后登录时间；
- XSS 安全防御；
- 第三方授权登录，目前支持 GitHub，兼容 Facebook，Twitter，LinkedIn，Google，GitHub，GitLab 和 Bitbucket 的身份验证；
- 支持自定义 meta title、description、keywords；
- 支持友链
- 站点地图

## 运行环境要求
- Nginx 1.8+
- PHP 7.0+
- Mysql 5.7+
- Redis 3.0+

## 开发环境部署和安装

本项目代码使用 PHP 框架 laravel6.x 开发，本地开发环境使用 [Laravel Homestead](https://xueyuanjun.com/post/19915.html)。

## 基础安装

1. 克隆源代码

克隆 `larablog` 源代码到本地：

```
// gitee
git clone git@gitee.com:pudongping/larablog.git

// GitHub
git clone git@github.com:pudongping/larablog.git

```

2. 安装扩展包依赖

```
// 先切换到 larablog 项目根目录
cd larablog

// 执行安装命令
composer install
```

3. 生成配置文件

```
cp .env.example .env
```

你可以根据情况修改 .env 文件里的内容，如数据库连接、缓存、邮件设置、第三方授权登录等：

```

DB_HOST=localhost
DB_DATABASE=larablog
DB_USERNAME=homestead
DB_PASSWORD=secret

```

4. 生成数据表及生成测试数据

```
// 需要生成测试数据则执行：
php artisan migrate --seed

// 不需要生成测试数据则执行：
php artisan migrate
```

5. 生成秘钥

```

php artisan key:generate

```

6. 创建 storage 软连接

```

php artisan storage:link

```

7. 赋予 storage 相应权限

```

// 建议在 Linux 系统中新建一个 www 用户，并设置该用户不可登录系统
useradd -s /sbin/nologin www

// 将项目目录所有权赋予 www 用户
chown -Rf www:www larablog

// 给 storage 目录赋权限
chmod -Rf 0755 larablog/storage/

```

6.  配置 hosts 文件  （如果直接想部署在线上环境，则跳过此步骤）

如果开发环境没有采用 Laravel Homestead 则 ip 映射以你实际为主，一般为 127.0.0.1。我这里使用的 Laravel Homestead 虚拟机的 ip 地址为：192.168.10.10

```
// Linux 或 MacOS 环境

echo "192.168.10.10   larablog.test" | sudo tee -a /etc/hosts

// Windows 环境
需要打开 C:/Windows/System32/Drivers/etc/hosts  文件，然后新增一行

192.168.10.10 larablog.test
```

## 前端安装

1. 安装 npm 和 yarn

**CentOS / Fedora / RHEL 环境下**

> 文档地址：https://yarn.bootcss.com/docs/install/#centos-stable

- 配置相应的 yum 源

```
curl --silent --location https://dl.yarnpkg.com/rpm/yarn.repo | sudo tee /etc/yum.repos.d/yarn.repo

curl --silent --location https://rpm.nodesource.com/setup_8.x | sudo bash -
```

- 之后执行以下任意一条命令，就可以了

```
sudo yum install yarn
## OR ##
sudo dnf install yarn
```

**Windows 环境下**

- 安装 node.js

直接去官网 [https://nodejs.org/en](https://nodejs.org/en/) 下载安装最新版本。

- 安装 Yarn

请安装最新版本的 Yarn —— [http://yarnpkg.cn/zh-Hans/docs/install](https://nodejs.org/en/)


2. 为 NPM 和 Yarn 配置淘宝镜像，加速安装包下载

```
npm config set registry=https://registry.npm.taobao.org

yarn config set registry https://registry.npm.taobao.org
```

3. 使用 Yarn 安装前端依赖包

```
yarn install

或者

npm install
```

- 监控 resources 文件夹下的资源文件是否有发生改变。在 watch-poll 命令运行的情况下，一旦资源文件发生变化，Webpack 会自动重新编译。

```
npm run watch-poll

// 如果遇到报错，尝试先执行以下命令更新 npm 到最新版本，之后再次执行监控命令
npm install -g npm
```

- 编译前端内容

```
// 运行所有 Mix 任务...
npm run dev

// 运行所有 Mix 任务并缩小输出..
npm run production
```

## 访问入口

- 首页地址： [http://larablog.test](http://larablog.test)
- 后台管理：[http://larablog.test/admin](http://larablog.test/admin)

管理员账号密码如下：

```
username: 1414818093@qq.com
password: 123456
```

默认网站第一位用户为站长角色，第二位用户为管理员角色。如果填充了测试数据，则默认所有用户的密码为：123456

==至此，安装完成^_^。enjoy yourself……==

## 后端扩展包使用情况

扩展包 | 简介描述 | 本项目应用场景
--- | --- | --- 
[laravel/ui](https://packagist.org/packages/laravel/ui) | laravel 6.x UI 脚手架 | 前端页面框架
[barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper) | 能让你的 IDE (PHPStorm, Sublime) 实现自动补全、代码智能提示和代码跟踪等功能 | 代码补全和智能提示
[barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) | 页面调试工具栏 (对 phpdebugbar 的封装) | 开发环境中的 DEBUG
[overtrue/laravel-lang](https://github.com/overtrue/laravel-lang) | 支持 52 个国家的语言包 | 翻译 Laravel 自带模板
[mews/captcha](https://github.com/mewebstudio/captcha) | 图片验证码 | 注册页面图片验证码
[intervention/image](https://github.com/Intervention/image) | 图片处理功能库 | 用于图片裁剪
[summerblue/laravel-active](https://github.com/summerblue-ext-forks/active) | 方便设置 active 类 | 文章排序添加 active 类
[mews/purifier](https://github.com/mewebstudio/Purifier) | 用户提交的 Html 白名单过滤 | 文章内容的 Html 安全过滤，防止 XSS 攻击
[guzzlehttp/guzzle](https://github.com/guzzle/guzzle) | HTTP 请求套件 | 请求百度翻译 API，翻译文章标题，做 SEO 优化
[overtrue/pinyin](https://github.com/overtrue/pinyin) | 基于 CC-CEDICT 词典的中文转拼音工具 | 翻译文章标题的备用方案
[predis/predis](https://github.com/nrk/predis) | Redis 官方首推的 PHP 客户端开发包 | 缓存驱动 Redis 基础扩展包
[laravel/horizon](https://learnku.com/docs/laravel/6.x/horizon/5190) | 队列监控 | 队列监控命令与页面控制台 /horizon
[spatie/laravel-permission](https://github.com/spatie/laravel-permission) | 角色权限管理 | 角色和权限控制
[viacreative/sudo-su](https://github.com/viacreative/sudo-su) | 用户切换 | 调试环境中快速切换登录账号
[erusev/parsedown](https://github.com/erusev/parsedown) | markdown 转换 html 工具 | 文章模块解析 markdown 语法
[thephpleague/html-to-markdown](https://github.com/thephpleague/html-to-markdown) | html 转换成 markdown 工具 | 文章编辑采用 markdown 编辑器时
[laravel/socialite](https://socialiteproviders.netlify.com/providers/git-hub.html) | laravel 官方推荐社会化登录 | Github 登录

## 前端扩展包使用情况

扩展包 | 简介描述 | 本项目应用场景
--- | --- | --- 
[yarn add @fortawesome/fontawesome-free](https://fontawesome.com/) | Font Awesome 提供了可缩放的矢量图标 | 字体图标库
[npm i startbootstrap-sb-admin-2](https://github.com/BlackrockDigital/startbootstrap-sb-admin-2) | 界面简洁美观的皮肤 | cms 后台模板 | 
[npm install simplemde](https://simplemde.com/) | markdown 编辑器 | 文章编辑器
[npm install highlight.js](https://highlightjs.org/) | 语法高亮工具 | markdown 编辑器代码语法高亮
[npm install inline-attachment](https://github.com/Rovak/InlineAttachment) | 文本框拖动上传图片工具 | markdown 文本框图片拖动上传
[multiselect.js](http://loudev.com) | 多选下拉框 | 文章多选标签
[chartjs](https://www.chartjs.org/) | 图表插件 | 后台管理界面图表


## 邮箱认证

- 开发环境时将 `.ENV` 文件设置为如下所示，将邮箱认证邮件发送至当前日志中，以便调试
    ```
    MAIL_DRIVER=log
    ```
- 生产环境时，建议将 `.ENV` 文件中相关邮件设置为自己所需配置，以下为默认配置
    ```
    MAIL_DRIVER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    ```
    
## 翻译队列
- 修改 `.ENV` 文件设置为

```

# 如果是开发环境的话，就把队列驱动改回 sync 同步模式，也就是说不使用任何队列，实时执行：
QUEUE_CONNECTION=redis
REDIS_CLIENT=predis

```

- 启动队列系统，队列在启动完成后会进入监听状态

```
php artisan queue:listen

或者使用

php artisan horizon

```
    
## 文章标题翻译
> [使用了百度翻译 api](http://api.fanyi.baidu.com/api/trans/product/apidoc)，请将 `.ENV`中的百度 api 相关信息换成你自己的[开发者信息](http://api.fanyi.baidu.com/api/trans/product/desktop?req=developer)

如果不采用百度翻译翻译文章标题的话，那么不用配置 `.ENV` 文件中以下配置项

```

# 百度翻译 APP ID
BAIDU_TRANSLATE_APPID=
# 百度翻译密钥 KEY
BAIDU_TRANSLATE_KEY=

```

并且也不需要更改

```

QUEUE_CONNECTION=redis

```

默认保持为

```

QUEUE_CONNECTION=sync

```

这样将会每发一篇文章时，将文章标题直接翻译成拼音达到 slug 的效果。


## 邮件通知

> 如果不想要，发表文章评论时有邮件通知，可以不用配置，直接忽略，功能上没有任何影响

1. 需要先开启 QQ 邮箱的 SMTP 支持   

[如何打开 POP3/SMTP/IMAP 功能？](https://service.mail.qq.com/cgi-bin/help?subtype=1&id=28&no=166)

2. 邮箱发送配置 （请将以下配置换成你自己的邮箱配置）

> 如果你是使用的阿里云 ECS，那么一定要注意，阿里云的 ECS 默认禁用了 25 端口，需要单独申请解封25端口，[点我解封阿里云 ECS 25端口](https://yundun.console.aliyun.com/?spm=5176.2020520101.console-base-top.duser-0.33bf4df5FEFEdS&p=sc#/sc/port)，如果你不知道如何解封，请查看 [解封步骤](https://help.aliyun.com/knowledge_detail/56130.html)。当然替代方案，你可以采用 465 端口，如果你打算采用 465 端口，那么需要将以下配置中的 `MAIL_PORT` 修改为 465,并且也需要将加密类型 `MAIL_ENCRYPTION` 修改为 ssl 即可，这里我才用的是 qq 邮箱，可能其他的邮箱服务有差异，视情况而定吧。

```
# 使用支持 ESMTP 的 SMTP 服务器发送邮件
MAIL_DRIVER=smtp
# QQ 邮箱的 SMTP 服务器地址，必须为此值
MAIL_HOST=smtp.qq.com
# QQ 邮箱的 SMTP 服务器端口，必须为此值
MAIL_PORT=25
# 请将此值换为你的 QQ + @qq.com
MAIL_USERNAME=xxxxxxxxxxxxxx@qq.com
# 密码是我们第一步拿到的授权码
MAIL_PASSWORD=xxxxxxxxx
# 加密类型，选项 null 表示不使用任何加密，其他选项还有 ssl，这里我们使用 tls 即可，如果出现报错的话，多半是因为这个 smtp 主机不支持 TLS，那么只需要将此项设置为 null 即可。
MAIL_ENCRYPTION=tls
# 此值必须同 MAIL_USERNAME 一致
MAIL_FROM_ADDRESS=xxxxxxxxxxxxxx@qq.com
# 用来作为邮件的发送者名称
MAIL_FROM_NAME=番茄炖土豆的个人博客
```

3. 如果需要支持队列，请将 `.ENV` 配置文件中，设置成

```

QUEUE_CONNECTION=redis

```

## 用户切换调试

默认只在调试模式 `.ENV` 文件中

```

APP_DEBUG=true

```

时启用，且 `config/sudosu.php` 文件中

```php

// 允许使用的顶级域名
'allowed_tlds' => ['dev', 'local', 'test'],
    
```   

顶级域名（Top Level Domain）加入你域名的顶级域名

## 第三方授权登录

目前项目中只支持 github 授权登录，因为只申请了 GitHub 的 OAuth application，如果你也需要使用 GitHub 作为第三方授权登录，那么需要按照以下步骤进行：

1. 在 GitHub 上注册一个 [OAuth application](https://github.com/settings/applications/new)

- Application name：你可以填写你自己的应用名称，比如：myWebBlog
- Homepage URL：首页连接地址需要添加你自己的，比如：http://larablog.test
- Application description：应用描述可以随便填写，比如：自己的博客
- Authorization callback URL：授权回调地址，一定要填写成： <Your domain>/login/github/callback  ，比如，我这里则需要填写成：http://larablog.test/login/github/callback

2. 注册成功之后，需要在 `.ENV` 配置文件中填写申请成功的 Client ID 和 Client Secret。填写好之后，直接访问  [http://larablog.test/login/github](http://larablog.test/login/github)  即可支持 GitHub 第三方授权登录，如果不设置 `.ENV` 配置文件，则登录、注册页面不会显示 GitHub 第三方授权登录入口。

```
# Github Client ID
GITHUB_CLIENT_ID=
# Github Client Secret
GITHUB_CLIENT_SECRET=
```

3. 扩展其它第三方授权登录。  
> Socialite 目前支持 Facebook，Twitter，LinkedIn，Google，GitHub，GitLab 和 Bitbucket 的身份验证。本项目已经对以上支持的第三方登录做了兼容性处理，如果我们需要支持以上除 GitHub 以外的应用（因为目前已经设置好了 GitHub 相关的配置），那么我们只需要按照以下的步骤配置即可。这里以 Google 为例子。

- 第一步：申请 `google` 的 Client ID 和 Client Secret。
- 第二步：将申请的 Client ID 和 Client Secret 填写入 `.ENV` 配置文件中

```
GOOGLE_CLIENT_ID="your google client id"
GOOGLE_CLIENT_SECRET="your google client secret"
```

- 第三步：配置 app/services.php

```
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),  // google 客户端授权 ID
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),  // google 客户端授权密钥
    'redirect' => '/login/google/callback',  // 授权回调链接 如果 redirect 配置项包含的是相对路径，系统会自动将其转化为完整 URL
],
```

- 第四步：将第三方服务添加到 `app/Models/Auth/User.php` => `$allowedProviders` 数组中

```
public static $allowedProviders = ['github', 'google'];
```

- 第五步：直接访问 <your domain>/login/google 即可


## 自定义 Artisan 命令

命令 | 说明 | Cron 
--- | --- | ---
php artisan larablog:calculate-active-user | 生成活跃用户 | 一个小时运行一次
php artisan larablog:sync-user-actived-at | 从 Redis 中同步最后登录时间到数据库中 | 每天早上 0 点准时


## 计划任务

当前计划任务主要是计算主页右侧 「活跃用户」

`artisan` 命令为：

```php

php artisan larablog:calculate-active-user

```

和同步 「用户最后活跃时间」 到数据库

`artisan` 命令为：

```php

php artisan larablog:sync-user-actived-at

```

并且已经在 `调度器` 中设置好了相关代码。（调度器在 app/Console/Kernel.php 文件的 schedule 方法中定义）

使用 Linux 系统的 Cron 计划任务需执行

```

export EDITOR=vi && crontab -e

```

然后填入以下内容（注意将项目根目录换成你自己的）  
这里我的项目根目录为：`/home/vagrant/Code/larablog`

```

* * * * * php /home/vagrant/Code/larablog/artisan schedule:run >> /dev/null 2>&1

```

> 如果不设定计划任务的话，直接执行以上 Artisan 命令的话会是如下情况：  
「活跃用户」将每 65 分钟重新生成一次，设定计划任务的话，默认一个小时重新生成一次。  
「用户最后活跃时间」将不会同步到数据库中，将会直接从 Redis 中获取，如果 Redis 中不存在，则以用户注册时间替代。

## 队列清单

文件路径 | 说明 | 调用时机
--- | --- | ---
app\Notifications\ArticleReplied.php | 通知文章作者有新评论回复 | 文章被评论以后 App\Observers\Portal\Article\ReplyObserver@created
app\Jobs\TranslateSlug.php | 将文章标题翻译为 Slug | 文章保存时 App\Observers\Portal\Article\ArticleObserver@saved

## 代码规范

遵循 [PSR-2](https://www.php-fig.org/psr/psr-2/) 编码风格规范    
遵循 [PSR-12](https://learnku.com/docs/psr/psr-12-extended-coding-style-guide/5789) 编码规范扩充

## 其他
代码中涵盖了丰富的注释，如果仍有不清楚之处，可以给我留言。  
如果你觉得还不错，请帮我点一下  Star，不胜感激 ！❤(❤´艸｀❤)

[GitHub](https://github.com/pudongping/larablog) 地址  
[码云](https://gitee.com/pudongping/larablog) 地址

## License

源代码基于 [MIT](https://opensource.org/licenses/MIT) 协议发布。
