<?php

use Faker\Generator as Faker;

$factory->define(\App\Podcast::class, function (Faker $faker) {
    return [
        'url' => $faker->url,
        'title' => $faker->title,
        'description' => $faker->text(400),
        'domain' => $faker->domainName,
        'logo' => $faker->imageUrl,
    ];
});
