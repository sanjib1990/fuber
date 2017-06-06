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
use Carbon\Carbon;
use App\Models\CabType;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Customer::class, function (Faker\Generator $faker) {
    $dumyLocations  = config('location');
    $randLoc        = $dumyLocations[array_rand($dumyLocations)];

    return [
        'name'          => $faker->name,
        'email'         => $faker->unique()->safeEmail,
        'mobile'        => $faker->numberBetween(1111111111, 9999999999),
        'base_lat'      => $randLoc['lat'],
        'base_lng'      => $randLoc['lng'],
        'created_at'    => Carbon::now()
    ];
});

$factory->define(App\Models\Cab::class, function (Faker\Generator $faker) {
    $dumyLocations  = config('location');
    $randLoc        = $dumyLocations[array_rand($dumyLocations)];

    /**
     * Get All cab types
     *
     * @var array
     */
    $cabTypes   = CabType::all()->pluck('id')->toArray();

    return [
        'name'          => $faker->slug,
        'cab_type_id'   => $cabTypes[array_rand($cabTypes)],
        'base_lat'      => $randLoc['lat'],
        'base_lng'      => $randLoc['lng'],
        'available'     => $faker->boolean,
        'created_at'    => Carbon::now()
    ];
});
