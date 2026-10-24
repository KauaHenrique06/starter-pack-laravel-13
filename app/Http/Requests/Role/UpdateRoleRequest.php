<?php

namespace App\Http\Requests\Role;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
                'exists:roles,id'
            ],
            'permissions' => [
                'present', // Required array but accept empty
                'array'
            ],
            'permissions.*' => [
                'distinct', // For dont accept uuid repeated
                'uuid',
                'exists:permissions,id'
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'id' => 'Role id',
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
