<?php

namespace App\Helpers;

class PageRuleHelper
{
    public static function rules(): array
    {
        return [
            'page' => [
                'sometimes',
                'integer',
                'min:1'
            ]
        ];
    } 

    public static function attributes(): array 
    {
        return [
            'page' => 'Page'
        ];
    }

    public static function prepareForValidation($request): array
    {
        return [
            'page' => $request->query('page', 1)
        ];
    }
}
