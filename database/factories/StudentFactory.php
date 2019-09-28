<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Model\Student;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Student::class, function (Faker $faker) {
    return [
        'parent_account_code' => $faker->numberBetween(100000, 999999),
        'email' => $faker->unique()->safeEmail,
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'idendity_no' => $faker->unique()->numberBetween(10000000000, 99999999999),
    ];
});
