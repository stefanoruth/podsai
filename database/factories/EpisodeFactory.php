<?php

use Faker\Generator as Faker;

$factory->define(App\Episode::class, function (Faker $faker) {
    return [
        'podcast_id' =>  function () {
            return factory(\App\Podcast::class)->create()->id;
        },
        'key' => $faker->uuid,
        'title' => $faker->title,
        'description' => $faker->text(1000),
        'link' => $faker->url,
        'audio' => $faker->url,
    ];
});
