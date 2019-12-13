<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019-12-13
 * Time: 10:18
 * link: 生成 rss 订阅： https://packagist.org/packages/suin/php-rss-writer
 *
 * 生成 rss 订阅
 *
 */

namespace App\Handlers;

use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;
use Carbon\Carbon;
use App\Models\Portal\Article\Article;

class RssFeedHandler
{

    protected $article;
    protected $feed;
    protected $channel;

    public function __construct(
        Article $article,
        Feed $feed,
        Channel $channel
    ) {
        $this->article = $article;
        $this->feed = $feed;
        $this->channel = $channel;
    }

    /**
     * 获取 rss 订阅相关代码
     *
     * @return mixed
     */
    public function fetchRss()
    {
        return \Cache::remember($this->article->cacheKeyForRssFeed, $this->article->cacheExpireInSeconds, function () {
            return $this->buildRss();
        });
    }

    /**
     * 生成 rss 订阅相关 xml 代码
     * @link https://packagist.org/packages/suin/php-rss-writer
     *
     * @return mixed|string
     */
    protected function buildRss()
    {
        $now = Carbon::now();
        $this->channel
            ->title(site_setting('site_name', 'Alex'))
            ->description(site_setting('seo_description'))
            ->url(url('/'))
            ->language('zh-CN')
            ->copyright('Copyright (c) ' . site_setting('founder_nickname'))
            ->lastBuildDate($now->timestamp)
            ->appendTo($this->feed);

        $articles = Article::select('id', 'slug', 'title', 'excerpt', 'created_at')
            ->where('created_at', '<=', $now)
            ->orderBy('order', 'desc')
            ->orderBy('id', 'desc')
            ->take(Article::RSS_SIZE)
            ->get();

        foreach ($articles as $article) {
            $item = new Item();
            $item
                ->title($article->title)
                ->description($article->excerpt)
                ->url($article->link())
                ->pubDate($article->created_at->timestamp)
                ->guid($article->link(), true)
                ->appendTo($this->channel);
        }

//        $feed = (string)$this->feed;
        $feed = $this->feed->render();  // 渲染成 xml 代码

        // 替换内容使得生成的 rss xml 代码更加兼容
        $feed = str_replace(
            '<channel>',
            '<channel>' . "\n" . '    <atom:link href="' . url('/rss') .
            '" rel="self" type="application/rss+xml" />',
            $feed
        );

        return $feed;
    }

}