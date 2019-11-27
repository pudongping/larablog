<?php

namespace App\Models\Admin\Menu;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['pid', 'name', 'link', 'auth', 'icon', 'description', 'sort'];
}
