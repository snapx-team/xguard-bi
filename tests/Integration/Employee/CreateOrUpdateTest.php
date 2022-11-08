<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Xguard\BusinessIntelligence\Enums\Roles;
use Xguard\BusinessIntelligence\Enums\SessionVariables;
use Xguard\BusinessIntelligence\Models\Employee;

class CreateOrUpdateTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    const CREATE_OR_UPDATE_EMPLOYEE = 'bi.createOrUpdateEmployees';
    const SELECTED_USERS = 'selectedUsers';
    const ID = 'id';
    const ROLE = 'role';
    const ADMIN = 'admin';
    const SELECTED_USERS_0_ID = 'selectedUsers.0.id';
    const EMPLOYEE = 'employee';

    public function setUp(): void
    {
        parent::setUp();
        $user = factory(User::class)->create();
        $employee = factory(Employee::class)->states(Roles::ADMIN()->getValue())->create([Employee::USER_ID => $user->id,]);
        Auth::setUser($user);
        session([SessionVariables::ROLE()->getValue() => Roles::ADMIN()->getValue(), SessionVariables::EMPLOYEE_ID()->getValue() => $employee->id]);
    }

    public function testCreateEmployees()
    {
        $apiCall = route(self::CREATE_OR_UPDATE_EMPLOYEE);
        $newUser1 = factory(User::class)->create();
        $newUser2 = factory(User::class)->create();
        $data = [
            self::SELECTED_USERS => [
                [
                    self::ID => $newUser1->id,
                ],
                [
                    self::ID => $newUser2->id,
                ]
            ],
            self::ROLE => self::ADMIN
        ];

        $this->post($apiCall, $data);
        $this->assertDatabaseHas(Employee::TABLE_NAME, [Employee::USER_ID => $newUser1->id]);
        $this->assertDatabaseHas(Employee::TABLE_NAME, [Employee::USER_ID => $newUser2->id]);
    }

    public function testUpdateEmployee()
    {
        $apiCall = route(self::CREATE_OR_UPDATE_EMPLOYEE);
        $existingUser = factory(User::class)->create();
        $existingEmployee = factory(Employee::class)->states(Roles::ADMIN()->getValue())->create([Employee::USER_ID => $existingUser->id,]);
        $this->assertDatabaseHas(Employee::TABLE_NAME, [Employee::USER_ID => $existingEmployee->id, Employee::ROLE => Roles::ADMIN()->getValue()]);
        $data = [
            self::SELECTED_USERS => [
                [
                    self::ID => $existingEmployee->id,
                ],
            ],
            self::ROLE => self::EMPLOYEE
        ];

        $this->post($apiCall, $data);
        $this->assertDatabaseHas(Employee::TABLE_NAME, [Employee::USER_ID => $existingEmployee->id, SessionVariables::ROLE()->getValue() => Roles::EMPLOYEE()->getValue()]);
    }

    public function testOnlyAdminCanCreateOrUpdate()
    {
        session([SessionVariables::ROLE()->getValue() => Roles::EMPLOYEE()->getValue()]);
        $apiCall = route(self::CREATE_OR_UPDATE_EMPLOYEE);
        $newUser = factory(User::class)->create();
        $data = [
            self::SELECTED_USERS => [
                [
                    self::ID => $newUser->id,
                ],
            ],
            self::ROLE => self::ADMIN
        ];

        $response = $this->post($apiCall, $data);
        $response->assertStatus(403);
    }

    public function testCreateOrUpdateValidation()
    {
        $apiCall = route(self::CREATE_OR_UPDATE_EMPLOYEE);
        $response = $this->post($apiCall, []);
        $response->assertSessionHasErrors([self::SELECTED_USERS, self::ROLE]);
        $response->assertStatus(302);
    }

    public function testCanOnlyCreateEmployeeIfUserExists()
    {
        $apiCall = route(self::CREATE_OR_UPDATE_EMPLOYEE);
        $data = [
            self::SELECTED_USERS => [
                [
                    self::ID => 1000,
                ],
            ],
            self::ROLE => self::ADMIN
        ];

        $response = $this->post($apiCall, $data);
        $response->assertSessionHasErrors([self::SELECTED_USERS_0_ID]);
    }
}
