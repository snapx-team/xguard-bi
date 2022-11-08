<?php

namespace Xguard\BusinessIntelligence\Http\Controllers;

use App\Http\Controllers\Controller;
use Xguard\BusinessIntelligence\Http\Requests\EmployeeRequests\EmployeeDeleteRequest;
use Xguard\BusinessIntelligence\Http\Requests\EmployeeRequests\EmployeePostRequest;
use Xguard\BusinessIntelligence\Repositories\EmployeesRepository;

class EmployeeController extends Controller
{
    public function createOrUpdateEmployees(EmployeePostRequest $request)
    {
        return EmployeesRepository::createOrUpdateEmployee($request->all());
    }

    public function deleteEmployee(EmployeeDeleteRequest $id)
    {
        return EmployeesRepository::deleteEmployee($id);
    }

    public function getAllEmployees()
    {
        return EmployeesRepository::getAllEmployees();
    }

    public function getEmployeeProfile()
    {
        return EmployeesRepository::getEmployeeProfile();
    }
}
