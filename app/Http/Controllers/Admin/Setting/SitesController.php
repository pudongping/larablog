<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\Setting\SitesRepository;
use App\Http\Requests\Admin\Setting\SiteRequest;

class SitesController extends Controller
{

    protected $sitesRepository;

    public function __construct(SitesRepository $sitesRepository)
    {
        $this->sitesRepository = $sitesRepository;
    }

    /**
     * 编辑站点设置显示页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $site = $this->sitesRepository->edit();
        return view('admin.site.edit', compact('site'));
    }

    /**
     * 更新站点设置
     *
     * @param SiteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SiteRequest $request)
    {
        $data = $this->sitesRepository->update($request);
        return redirect()->route('sites.edit')->with('success', '站点设置成功！');
    }

    /**
     * 清空所有缓存
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCache()
    {
        \Cache::flush();
        // \Artisan::call('cache:clear');
        return redirect()->route('sites.edit')->with('success', '系统缓存清理成功！');
    }

}
