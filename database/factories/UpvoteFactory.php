<?php
/**
 * Created by PhpStorm.
 * User: luoxiongwen
 * Date: 2017/12/16
 * Time: 上午11:23
 */

use Faker\Generator as Faker;

$factory->define(App\Models\Upvote::class, function (Faker $faker) {

    $time = $faker->dateTimeThisMonth();

    return [
        'created_at' => $time,
        'updated_at' => $time,
    ];
});