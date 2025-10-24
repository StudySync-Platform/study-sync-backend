<?php

namespace App\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;

class RegisterInput
{
    protected $attributes = [
        'first_name' => 'RegisterInput',
        'last_name' => 'RegisterInput',
        'description' => 'Input for user registration',
    ];

    public function fields(): array
    {
        return [
            'first_name' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'last_name' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
            ],
        ];
    }
}
