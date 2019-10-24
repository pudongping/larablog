<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019-10-24
 * Time: 15:04
 */

namespace App\Repositories\Portal\Article;

use App\Repositories\BaseRepository;
use App\Models\Portal\Article\Reply;

class RepliesRepository extends BaseRepository
{
    protected $model;

    public function __construct(Reply $reply)
    {
        $this->model = $reply;
    }

    /**
     * 保存回复数据
     *
     * @param $request
     * @return mixed
     */
    public function storage($request)
    {
        $input = $request->only(['article_id', 'content']);
        $input['user_id'] = \Auth::id();
        return $this->store($input);
    }

}
