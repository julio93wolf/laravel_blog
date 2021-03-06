<?php

use Faker\Generator as Faker;

$factory->define(Blog\Models\Category::class, function (Faker $faker) {
    $title = $faker->sentence(4);
    return [
        'name' => $title,
        'slug' => str_slug($title),
        'body' => $faker->text(500)
    ];
});
