<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/27
 * Time: 1:14
 */

namespace App\Models\Admin\Authorize;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{

    const DEFAULT_ROLES = ['Founder'];

}