<?php

namespace App\GraphQL\Queries\Room;

use App\Models\Room;

class FindRoom
{
    public function __invoke($_, array $args)
    {
        return Room::with(['studySessions.members'])->where('id', $args['id'])->firstOrFail();
    }
}
