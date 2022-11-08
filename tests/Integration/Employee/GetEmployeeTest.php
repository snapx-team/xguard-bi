<?php

namespace Tests\Unit\Actions\Users;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Xguard\BusinessIntelligence\Enums\Roles;
use Xguard\BusinessIntelligence\Enums\SessionVariables;
use Xguard\BusinessIntelligence\Models\Employee;

class GetEmployeeTest extends TestCase
{
    use RefreshDatabase;

    const GET_EMPLOYEE = 'bi.getEmployees';
    const DATA = 'data';
    const ID = 'id';
    const CREATED_AT = 'createdAt';
    const FULL_NAME = 'fullName';
    const LANGUAGE = 'language';
    const ROLE = 'role';
    const USER = 'user';

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        Auth::setUser($this->user);
        $this->employee = factory(Employee::class)->states(Roles::ADMIN()->getValue())->create([Employee::USER_ID  => $this->user->id]);
        session([SessionVariables::ROLE()->getValue() => Roles::ADMIN()->getValue(), SessionVariables::EMPLOYEE_ID()->getValue() => $this->employee->id]);
    }

    public function testGetAllEmployees()
    {
        $apiCall = route(self::GET_EMPLOYEE);
        $response = $this->get($apiCall);
        $response->assertOk();
        $response->assertJsonStructure([
            self::DATA => [
                '*' => [
                    self::ID,
                    self::ROLE,
                    self::CREATED_AT,
                    self::USER => [
                        self::FULL_NAME,
                        self::LANGUAGE,
                    ]
                ],
            ]]);

        $responseData = json_decode($response->getContent(), true);
        $firstEmployee = $responseData[self::DATA][0];

        $this->assertEquals($this->employee->user->full_name, $firstEmployee[self::USER][self::FULL_NAME]);
        $this->assertEquals($this->employee->role, $firstEmployee[self::ROLE]);
        $this->assertEquals(Carbon::parse($this->employee->created_at)->toDateString(), Carbon::parse($firstEmployee[self::CREATED_AT])->toDateString());
        $this->assertEquals($this->employee->user->locale, $firstEmployee[self::USER][self::LANGUAGE]);
    }
}
