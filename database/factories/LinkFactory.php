<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin\Setting\Link;
use Faker\Generator as Faker;

$factory->define(Link::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'link' => $faker->url,
    ];
});
