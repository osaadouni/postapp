<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {

    // Get a random user
    //
    $user =  \App\User::inRandomOrder()->first();

    // generate fake data for post 
    //
    return [
        
        'user_id'   => $user->id, 

        'title'     => $faker->sentence, 

        'body'      => $faker->realText(rand(100, 676)), 

        'cover_pic' => $faker->imageUrl()

    ];
});
