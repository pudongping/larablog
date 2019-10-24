<?php

namespace App\Http\Controllers\Portal\Article;

use App\Http\Controllers\Controller;
use App\Models\Portal\Article\Reply;
use Illuminate\Http\Request;
use App\Http\Requests\Portal\Article\ReplyRequest;
use App\Repositories\Portal\Article\RepliesRepository;

class RepliesController extends Controller
{

    protected $repliesRepository;

    public function __construct(RepliesRepository $repliesRepository)
    {
        $this->repliesRepository = $repliesRepository;
    }

    /**
     * 评论文章
     *
     * @param ReplyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReplyRequest $request)
    {
        $reply = $this->repliesRepository->storage($request);

        return redirect()->to($reply->article->link())->with('success', '评论创建成功！');
    }

    /**
     * 删除评论
     *
     * @param Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Reply $reply)
    {
        // 删除评论策略
        $this->authorize('destroyPolicy', $reply);

        $reply->delete();

        return redirect()->route('articles.index')->with('success', '评论删除成功！');
    }


}
