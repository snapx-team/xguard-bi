<?php

namespace Xguard\BusinessIntelligence\Http\Requests\EmployeeRequests;

use Xguard\BusinessIntelligence\Enums\Roles;
use Xguard\BusinessIntelligence\Enums\SessionVariables;
use Xguard\BusinessIntelligence\Http\Requests\BaseFormRequest;

class EmployeeDeleteRequest extends BaseFormRequest
{
    const ID = 'id';

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data[self::ID] = $this->route(self::ID);
        return $data;
    }

    public function authorize(): bool
    {
        return (session(SessionVariables::ROLE()->getValue()) === Roles::ADMIN()->getValue());
    }

    public function rules(): array
    {
        return [
            self::ID => 'required|exists:Xguard\BusinessIntelligence\Models\Employee,id'
        ];
    }
}
