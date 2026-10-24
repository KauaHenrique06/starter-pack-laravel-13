<?php

namespace App\Http\Requests\Permission;

use App\Helpers\PageRuleHelper;
use App\Helpers\PerPageRuleHelper;
use App\Helpers\SearchRuleHelper;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexPermissionRequest extends FormRequest
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
            ...PageRuleHelper::rules(),
            ...PerPageRuleHelper::rules(),
            ...SearchRuleHelper::rules(),
        ];
    }

    public function attributes(): array
    {
        return [
            ...PageRuleHelper::attributes(),
            ...PerPageRuleHelper::attributes(),
            ...SearchRuleHelper::attributes(),
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            ...PageRuleHelper::prepareForValidation($this),
            ...PerPageRuleHelper::prepareForValidation($this),
            ...SearchRuleHelper::prepareForValidation($this),
        ]);
    }
}
