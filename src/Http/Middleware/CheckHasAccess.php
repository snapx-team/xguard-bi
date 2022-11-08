<?php

namespace Xguard\BusinessIntelligence\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Xguard\BusinessIntelligence\Models\Employee;

class CheckHasAccess
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $employee = Employee::where(Employee::USER_ID, '=', Auth::user()->id)->first();
            if ($employee === null) {
                abort(403, "You need to be added to the business intelligence app. Please ask an admin for access.");
            }
        } else {
            abort(403, "Please first login to ERP");
        }
        return $next($request);
    }
}
