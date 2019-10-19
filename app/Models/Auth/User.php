<?php

namespace App\Models\Auth;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use Notifiable, MustVerifyEmailTrait;

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
        if (!$value) $value = self::DEFAULT_HEADER;
        return config('app.url') . $value;
    }

}
