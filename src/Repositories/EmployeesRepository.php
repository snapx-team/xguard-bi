<?php

namespace Xguard\BusinessIntelligence\Repositories;

use Carbon;
use DB;
use Xguard\BusinessIntelligence\Enums\SessionVariables;
use Xguard\BusinessIntelligence\Http\Resources\EmployeeResource;
use Xguard\BusinessIntelligence\Models\Employee;

class EmployeesRepository
{
    const USER_NAME = 'userName';
    const USER_STATUS = 'userStatus';
    const USER_CREATED_AT = 'userCreatedAt';
    const LANGUAGE = 'language';

    public static function findOrFail(int $id): Employee
    {
        return Employee::findOrFail($id);
    }

    public static function getAllEmployees()
    {
        $employees = Employee::with(Employee::USER_RELATION_NAME)->get();
        return EmployeeResource::collection($employees);
    }

    public static function getEmployeeProfile()
    {
        $employee = Employee::with(Employee::USER_RELATION_NAME)->get()->find(session(SessionVariables::EMPLOYEE_ID()->getValue()));

        return [
            self::USER_NAME => $employee->user->full_name,
            self::USER_STATUS => $employee->role,
            self::USER_CREATED_AT => Carbon::parse($employee->created_at)->toDateString(),
            self::LANGUAGE => $employee->user->locale
        ];
    }

    public static function deleteEmployee($id)
    {
        try {
            DB::beginTransaction();
            $employee = Employee::find($id);
            $employee->each->delete();
            DB::commit();
            return response([], 200);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public static function createOrUpdateEmployee($employeeData)
    {
        try {
            DB::beginTransaction();
            $employees = [];
            $createdCount = 0;
            $updatedCount = 0;
            foreach ($employeeData['selectedUsers'] as $user) {
                $employee = Employee::updateOrCreate(
                    [Employee::USER_ID => $user['id']],
                    [Employee::ROLE => $employeeData['role']]
                );
                array_push($employees, $employee);
            }
            DB::commit();

            foreach ($employees as $employee) {
                if ($employee->wasRecentlyCreated) {
                    $createdCount++;
                } elseif ($employee->wasChanged()) {
                    $updatedCount++;
                }
            }
            return response(['created' => $createdCount, 'updated' => $updatedCount], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
