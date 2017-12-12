<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

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

$factory->define(App\Models\Admin::class, function (Faker $faker) {
    $now = Carbon::now();
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'created_at' => $now,
        'updated_at' => $now
    ];
});

$factory->state(App\Models\Admin::class, 'admin_default', function ($faker) {
    return [
        'email' => 'admin@test.test',
    ];
});