<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Business;

// Business factory
$factory->define(Business::class, function (Faker $faker)
{
    return [
        'name'   => 'My Test Business',
        'email'  => 'admin@mybusiness.com',
        'logo'   => '/images/logo.jpg',
        'domain' => 'http://127.0.0.1:8000/',
    ];
});
