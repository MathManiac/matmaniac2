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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function(Faker\Generator $faker) {
    return [
        'name' =>  $faker->sentence(4)
    ];
});

$factory->define(App\Subject::class, function(Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(4)
    ];
});

$factory->define(App\SubjectColumn::class, function(Faker\Generator $faker) {
    return [
        'locale' => 'da',
        'name' => $faker->sentence(3),
        'text' => $faker->text()
    ];
});