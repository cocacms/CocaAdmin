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
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(\Module\Shop\Models\Order::class, function (Faker\Generator $faker) {


    return [
        'oid' => order_id_create(),
        'uid' => 1,
        'account' => 'test1',
        'pic' => '/storage/uploads/20170813/9uMGcsJ2wGQfgBMpnUW5l6DEOsdImPVKXcBD1UxR.jpeg',
        'size' => mt_rand(32,44),
        'remark' => str_random(10),
        'addressee' => str_random(10),
        'tel' => str_random(10),
        'address' => str_random(10),
        'status' => mt_rand(1,4),
        'waybill' => str_random(10),
        'waybill_type' => 'sf',
        'amount' => mt_rand(100,3000)
    ];
});