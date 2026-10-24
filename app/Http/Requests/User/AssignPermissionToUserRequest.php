<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AssignPermissionToUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => [
                'required',
                'uuid',
                'exists:users,id'
            ],
            'permissions' => [
                'present',
                'array' 
            ],
            'permissions.*' => [
                'distinct',
                'uuid',
                'exists:permissions,id'
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'id' => 'User id',
            'permissions' => 'Permissions',
            'permissions.*' => 'Permissions ids'
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id')
        ]);
    }
}
