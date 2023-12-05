<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'fields' => [
        'example_integer' => [
            'type' => 'integer',
            'category' => 'user',
            'name' => 'example_integer',
            'value' => [
                'data' => 1024,
            ],
        ],
        'example_string' => [
            'type' => 'string',
            'category' => 'user',
            'name' => 'example_string',
            'value' => [
                'data' => 'Enabled',
            ],
        ],
        'emails' => [
            'type' => 'array_of_emails',
            'category' => 'manager',
            'name' => 'emails',
            'value' => [],
        ],
    ],
    'types' => [
        'integer' => [
            'value.data' => 'required|numeric|max:1024',
        ],
        'string' => [
            'value.data' => 'required|string|max:100',
        ],
        'array_of_emails' => [
            'value.*' => 'email',
        ],
    ],
    'categories' => [
        'manager',
        'user',
    ],
];
