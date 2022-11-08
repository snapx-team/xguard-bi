<?php

/** @var Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Xguard\BusinessIntelligence\Enums\Roles;
use Xguard\BusinessIntelligence\Models\Employee;

$factory->define(Employee::class, function (Faker $faker) {

    return [
        Employee::USER_ID => factory(User::class),
        Employee::ROLE =>  Roles::EMPLOYEE()->getValue()
    ];
});

$factory->state(Employee::class, Roles::ADMIN()->getValue(), function (Faker $faker) {
    return [
        Employee::ROLE => Roles::ADMIN()->getValue(),
    ];
});
