<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
            'name' => [
                'sometimes',
                'string',
                'max:255'
            ],
            'email' => [
                'sometimes',
                'email',
                'max:255'
            ],
            'password' => [
                'sometimes',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->letters()
                    ->symbols()
            ],
            'requires_2fa' => [
                'sometimes',
                'boolean'
            ],
            'role' => [
                'sometimes',
                'uuid',
                'exists:roles,id',
                Rule::prohibitedIf(fn() => !$this->user()->hasRole('admin')) // Blocked for normal user change role for admin
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'id' => 'User id',
            'name' => 'Name',
            'email' => 'E-mail',
            'password' => 'Password',
            'requires_2fa' => 'Requires two factor auth',
            'role' => 'Role'
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id')
        ]);
    }
}
