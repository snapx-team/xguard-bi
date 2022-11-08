<?php

namespace Xguard\BusinessIntelligence\Http\Requests\EmployeeRequests;

use Xguard\BusinessIntelligence\Enums\Roles;
use Xguard\BusinessIntelligence\Enums\SessionVariables;
use Xguard\BusinessIntelligence\Http\Requests\BaseFormRequest;

class EmployeePostRequest extends BaseFormRequest
{
    const SELECTED_USERS = 'selectedUsers';
    const ROLE = "role";
    const ID = 'id';

    public function authorize(): bool
    {
        return (session(SessionVariables::ROLE()->getValue()) === Roles::ADMIN()->getValue());
    }

    public function rules(): array
    {
        return [
            self::SELECTED_USERS => ['present', 'array'],
            self::SELECTED_USERS . '.*.'. self::ID => 'required|exists:App\Models\User,id',
            self::ROLE => ['required', 'string'],];
    }

    public function messages(): array
    {
        return [
            self::SELECTED_USERS . '.present' => 'No selected users',
            self::ROLE .'.required' => 'Employee role is required',
        ];
    }
}
