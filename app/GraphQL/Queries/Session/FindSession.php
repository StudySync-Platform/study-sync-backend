<?php

namespace App\GraphQL\Queries\Session;

use App\Models\Session;

class FindSession
{
    public function __invoke($_, array $args)
    {
        return Session::where('id', $args['id'])->firstOrFail();
    }
}
