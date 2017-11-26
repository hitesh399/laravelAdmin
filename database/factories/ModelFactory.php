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
$roles = \App\Models\Role::all()->pluck('id')->toArray();

$factory->define(App\User::class, function (Faker\Generator $faker) use($roles) {
    static $password;

    $role_id = count($roles)?$faker->randomElement($roles):null;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'mobile_no' => '+91-'.$faker->unique()->numberBetween(10000000,9999999999),
        'password' => $password ?: $password = bcrypt(12345678),
        'remember_token' => str_random(10),
        'role_id'=>$role_id
    ];
});


$factory->define(App\Models\EmailTemplate::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->unique()->name,
        'body' => $faker->text(),
        'subject' => $faker->sentence(5),
        'bcc' => $faker->email,
        'cc' => $faker->email,
        'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s')
    ];
});
