<?php

namespace App\Helpers;

class PerPageRuleHelper
{
    public static function rules(): array
    {
        return [
            'perPage' => [
                'sometimes',
                'integer',
                'min:1'
            ]
        ];
    } 

    public static function attributes(): array 
    {
        return [
            'perPage' => 'Per Page'
        ];
    }

    public static function prepareForValidation($request): array
    {
        return [
            'perPage' => $request->query('perPage', 10)
        ];
    }
}
