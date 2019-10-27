<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/27
 * Time: 1:14
 * @link https://learnku.com/articles/19477 Laravel-permission 中文翻译
 */

namespace App\Models\Admin\Authorize;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{

    /**
     * 默认权限，不允许删除
     */
    const DEFAULT_PERMISSIONS = [
        'manage_setting',
        'manage_contents',
        'manage_users'
    ];

}