<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/12/7
 * Time: 23:10
 * link: 网站地图爬虫在线工具：http://help.bj.cn/
 *
 * 生成网站地图
 *
 */

namespace App\Handlers;

use App\Models\Portal\Article\Article;
use Carbon\Carbon;

class SiteMapHandler
{

    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * 获取站点地图
     *
     * @return mixed
     */
    public function fetchSiteMap()
    {
        return \Cache::remember($this->article->cacheKeyForSiteMap, $this->article->cacheExpireInSeconds, function () {
            return $this->buildSiteMap();
        });
    }

    /**
     * 生成站点地图 xml 代码
     * @link 网站地图爬虫在线工具：http://help.bj.cn/
     *
     * @return string
     */
    protected function buildSiteMap()
    {
        $articleInfo = $this->getArticleInfo();
        $dates = array_values($articleInfo);
        sort($dates);
        $lastmod = last($dates);
        // 获取当前网站的 url
        $url = trim(url('/'), '/') . '/';

        $xml = [];
        $xml[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        $xml[] = '  <url>';
        $xml[] = "    <loc>$url</loc>";
        $xml[] = "    <lastmod>$lastmod</lastmod>";
        $xml[] = '    <changefreq>daily</changefreq>';
        $xml[] = '    <priority>0.8</priority>';
        $xml[] = '  </url>';
        foreach ($articleInfo as $slug => $lastmod) {
            $xml[] = '  <url>';
            $xml[] = "    <loc>{$url}articles/$slug</loc>";
            $xml[] = "    <lastmod>$lastmod</lastmod>";
            $xml[] = "  </url>";
        }

        $xml[] = '</urlset>';
        return join("\n", $xml);
    }

    /**
     * 获取文章所有信息
     *
     * @return array
     */
    protected function getArticleInfo()
    {
        $articles = Article::select('id', 'slug', 'updated_at')
            ->where('created_at', '<=', Carbon::now())
            ->orderBy('order', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $data = [];
        foreach ($articles as $article) {
            $data[$article->id . '/' . $article->slug] = $article->updated_at;
        }
        return $data;
    }

}
