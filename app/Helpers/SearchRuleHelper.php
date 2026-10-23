<?php

namespace App\Helpers;

class SearchRuleHelper
{
    public static function rules(): array
    {
        return [
            'search' => [
                'sometimes',
                'string'
            ]
        ];
    } 

    public static function attributes(): array 
    {
        return [
            'search' => 'Search'
        ];
    }

    public static function prepareForValidation($request): array
    {
        return [
            'search' => $request->query('search', '')
        ];
    }
}
