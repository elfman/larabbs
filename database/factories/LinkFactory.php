<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Link::class, function (Faker $faker) {

    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'title' => $faker->name,
        'link'=>$faker->url,
        'updated_at' => $updated_at,
        'created_at' => $created_at,

    ];
});
