<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'avatar' => 'avatar_'.rand(1, 5).'.jpg',
        'birthday' => $faker->date(),
        'location' => $faker->city.' '.$faker->country,
        'contact' => $faker->phoneNumber,
        'about' => $faker->sentences(3, true),
        'gender' => $faker->randomElement(['male', 'female']),
        'status' => $faker->randomElement(['activated', 'pending', 'suspended']),
        'api_token' => str_random(60),
        'token' => str_random(50),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Portfolio::class, function (Faker\Generator $faker) {
    return [
        'user_id' => rand(1, 30),
        'category_id' => rand(1, 13),
        'title' => $faker->words(3, true),
        'description' => $faker->sentences(10, true),
        'reference' => $faker->url,
        'date' => $faker->date(),
        'company' => $faker->company,
        'vote' => rand(1, 200)
    ];
});

$factory->define(App\Screenshot::class, function (Faker\Generator $faker) {
    return [
        'portfolio_id' => rand(1, 100),
        'caption' => $faker->words(3, true),
        'source' => 'screenshot_'.rand(1, 5).'.jpg',
        'is_featured' => $faker->boolean()
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'tag' => $faker->words(2, true)
    ];
});

$factory->define(App\PortfolioTag::class, function (Faker\Generator $faker) {
    return [
        'portfolio_id' => rand(1, 100),
        'tag_id' => rand(1, 10)
    ];
});