<?php

namespace Xguard\BusinessIntelligence\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Xguard\BusinessIntelligence\Enums\DateTimeFormats;
use Xguard\BusinessIntelligence\Enums\SessionVariables;
use Xguard\BusinessIntelligence\Models\Employee;

class AppController extends Controller
{
    const IS_LOGGED_IN = 'is_logged_in';
    const PARENT_NAME = 'parent_name';
    const VERSION = 'version';
    const DATE = 'date';

    public function getIndex()
    {
        $this->setBusinessIntelligenceAppSessionVariables();
        return view('Xguard\BusinessIntelligence::index');
    }

    public function setBusinessIntelligenceAppSessionVariables()
    {
        if (Auth::check()) {
            $employee = Employee::where(Employee::USER_ID, '=', Auth::user()->id)->first();
            session([SessionVariables::ROLE()->getValue() => $employee->role, SessionVariables::EMPLOYEE_ID()->getValue() => $employee->id]);
            return [self::IS_LOGGED_IN => true];
        }
        return [self::IS_LOGGED_IN => false];
    }

    public function getRoleAndEmployeeId(): array
    {
        return [
            SessionVariables::ROLE()->getValue() => session(SessionVariables::ROLE()->getValue()),
            SessionVariables::EMPLOYEE_ID()->getValue() => session(SessionVariables::EMPLOYEE_ID()->getValue()),
        ];
    }

    public function getFooterInfo(): array
    {
        return [
            self::PARENT_NAME => config('bi.parent_name'),
            self::VERSION => config('bi.version'),
            self::DATE => date(DateTimeFormats::DATE_FORMAT_YEAR_ONLY)
        ];
    }
}
