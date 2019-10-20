<?php

namespace App\Models\Portal\Article;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'description',
    ];

}
