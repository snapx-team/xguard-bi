<?php

namespace Xguard\BusinessIntelligence\database\seeds;

use Illuminate\Database\Seeder;
use Xguard\BusinessIntelligence\Enums\Roles;
use Xguard\BusinessIntelligence\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        Employee::create([
            Employee::USER_ID => 1,
            Employee::ROLE => Roles::ADMIN()->getValue(),
        ]);
        Employee::create([
            Employee::USER_ID  => 2,
            Employee::ROLE => Roles::ADMIN()->getValue(),
        ]);
        Employee::create([
            Employee::USER_ID  => 3,
            Employee::ROLE => Roles::ADMIN()->getValue(),
        ]);
    }
}
