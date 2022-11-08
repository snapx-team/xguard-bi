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

class GetEmployeeProfileTest extends TestCase
{
    use RefreshDatabase;

    const GET_EMPLOYEE_PROFILE = 'bi.getEmployeeProfile';
    const USER_NAME = 'userName';
    const USER_STATUS = 'userStatus';
    const USER_CREATED_AT = 'userCreatedAt';
    const LANGUAGE = 'language';

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        Auth::setUser($this->user);
        $this->employee = factory(Employee::class)->states(Roles::ADMIN()->getValue())->create([Employee::USER_ID  => $this->user->id]);
        session([SessionVariables::ROLE()->getValue() => Roles::ADMIN()->getValue(), SessionVariables::EMPLOYEE_ID()->getValue() => $this->employee->id]);
    }

    public function testGetUserProfileAction()
    {
        $apiCall = route(self::GET_EMPLOYEE_PROFILE);
        $response = $this->get($apiCall);
        $this->assertEquals($this->employee->user->full_name, $response[self::USER_NAME]);
        $this->assertEquals($this->employee->role, $response[self::USER_STATUS]);
        $this->assertEquals(Carbon::parse($this->employee->created_at)->toDateString(), $response[self::USER_CREATED_AT]);
        $this->assertEquals($this->employee->user->locale, $response[self::LANGUAGE]);
    }
}
