<?php

namespace App\Models\Auth;

use App\Models\Portal\Article\Reply;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use App\Models\Portal\Article\Article;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\ActiveUserHelper;
use App\Traits\LastActivedAtHelper;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use Notifiable, MustVerifyEmailTrait, HasRoles, ActiveUserHelper, LastActivedAtHelper;


//    use Notifiable {
//        notify as protected laravelNotify; // 给 Notifiable Trait 中的 notify 方法起别名
//    }
//
//    /**
//     * 每次调用 notify 方法时，自动将 users 表里的 notification_count +1
//     * 重写了 Notifiable Trait 中的 notify 方法
//     * 『\Illuminate\Notifications\RoutesNotifications::notify』
//     *
//     * @param $instance
//     */
//    public function notify($instance)
//    {
//        // 如果要通知的人是当前用户，就不必通知了
//        if ($this->id == \Auth::id()) return;
//
//        // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
//        if (method_exists($instance, 'toDatabase')) {
//            $this->increment('notification_count');
//        }
//
//        // 最后还是需要调用 Notifiable Trait 中的 notify 方法来发送通知
//        $this->laravelNotify($instance);
//    }



    // 用户默认头像
    const DEFAULT_HEADER = '/uploads/portal/img/auth/default-header.png';

    /**
     * 防止用户随意修改模型数据，只有在此属性里定义的字段，才允许修改，否则更新时会被忽略
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 获取用户的头像路径
     *
     * @param $value  string  用户头像相对路径
     * @return string  用户头像带 url 链接的绝对路径
     */
    public function getAvatarAttribute($value)
    {
        return empty($value) ? self::DEFAULT_HEADER : $value;
    }

    /**
     * 用户-文章 一对多关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id', 'id');
    }

    /**
     * 一个用户可以拥有多条评论
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class, 'user_id', 'id');
    }

    /**
     * 授权验证
     *
     * @param $model  需要检验的模型实例
     * @return bool  当前用户可以操作则为 true，反之为 false
     */
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    /**
     * 标记通知消息为已读
     */
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        // 该方法来自 「Illuminate\Notifications\HasDatabaseNotifications::unreadNotifications」 Trait
        $this->unreadNotifications->markAsRead();
    }

    /**
     * 获取粉丝数据（用户和粉丝多对多关系）
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fans()
    {
        // 关联模型、关联中间表、定义此关联的模型在中间表里的外键名、另一个模型在中间表里的外键名
        return $this->belongsToMany(User::class, 'fans', 'user_id', 'fan_id');
    }

    /**
     * 获取用户关注了多少人 （粉丝和用户多对多关系）
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fanings()
    {
        return $this->belongsToMany(User::class, 'fans', 'fan_id', 'user_id');
    }

    /**
     * 关注用户
     *
     * @param array $userIds
     */
    public function follow(array $userIds)
    {
        // 第一个参数为需要关注人的 id 数组，第二个参数为：是否清空之前已关注的人，默认清空，不清空的情况下也不会有重复值
        $this->fanings()->sync($userIds, false);
    }

    /**
     * 取消关注
     *
     * @param array $userIds
     */
    public function unfollow(array $userIds)
    {
        $this->fanings()->detach($userIds);
    }

    /**
     * 当前登录的用户 A 是否关注了某个人（比如用户 B）
     * （判断用户 B 是否包含在用户 A 的关注人列表上）
     *
     * @param $userId int 用户 B 的 id
     * @return mixed
     */
    public function isFollowing($userId)
    {
        return $this->fanings->contains($userId);
    }

    /**
     * 计算用户的文章总数
     */
    public function upadteArticleCount()
    {
        $this->article_count = $this->articles->count();
        $this->save();
    }

}
