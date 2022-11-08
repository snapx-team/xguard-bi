<?php

namespace Tests\Unit\Actions\Employees;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Xguard\BusinessIntelligence\Enums\Roles;
use Xguard\BusinessIntelligence\Enums\SessionVariables;
use Xguard\BusinessIntelligence\Models\Employee;

class DeleteEmployeeTest extends TestCase
{
    use RefreshDatabase;

    const DELETE_EMPLOYEE = 'bi.deleteEmployee';
    const NON_EXISTING_USER_ID = 100;
    const ID = 'id';

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->employee = factory(Employee::class)->states(Roles::ADMIN()->getValue())->create([Employee::USER_ID  => $this->user->id]);
        Auth::setUser($this->user);
        session([SessionVariables::ROLE()->getValue() => Roles::ADMIN()->getValue(), SessionVariables::EMPLOYEE_ID()->getValue() => $this->user->id]);
    }

    public function testDeletionOfEmployee()
    {
        $newUser = factory(User::class)->create();
        $newEmployee = factory(Employee::class)->states(Roles::ADMIN()->getValue())->create([Employee::USER_ID => $newUser->id]);
        $this->assertNotNull(Employee::where(Employee::ID, $newEmployee->id)->first());
        $apiCall = route(self::DELETE_EMPLOYEE, [Employee::ID => $newEmployee->id]);
        $this->delete($apiCall);
        $this->assertNull(Employee::where(Employee::ID, $newEmployee->id)->first());
    }

    public function testOnlyAdminCanDelete()
    {
        session([SessionVariables::ROLE()->getValue() => Roles::EMPLOYEE()->getValue()]);
        $newUser = factory(User::class)->create();
        $newEmployee = factory(Employee::class)->create([Employee::USER_ID => $newUser->id]);
        $this->assertNotNull(Employee::where(Employee::ID, $newEmployee->id)->first());
        $apiCall = route(self::DELETE_EMPLOYEE, [Employee::ID => $newEmployee->id]);
        $response = $this->delete($apiCall);
        $response->assertStatus(403);
    }

    public function testIdMustExistInEmployeesTable()
    {
        $apiCall = route(self::DELETE_EMPLOYEE, [Employee::ID => self::NON_EXISTING_USER_ID]);
        $response = $this->delete($apiCall);
        $response->assertSessionHasErrors([self::ID]);
        $response->assertStatus(302);
    }
}
