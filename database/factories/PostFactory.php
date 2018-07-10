<?php

use Faker\Generator as Faker;
use Faker\Provider\Base;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title'     => $faker->sentence, //текст рыба
        'description'   => $faker->sentence(20),
        'content'   => $faker->sentence(400),
        'image'     => 'photo4.jpg',
        'date'      => $faker->date($format = 'd/m/y', $max = 'now'), //случайная дата
        'views'     => $faker->numberBetween($min = 1, $max = 9000),
        'category_id' => $faker->numberBetween($min = 3, $max = 6),
        'user_id'   => 1,
        'status'    => 1,
        'is_featured' => 0
    ];
});
