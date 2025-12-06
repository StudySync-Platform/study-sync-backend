<?php

namespace App\GraphQL\Queries\Habit;

use App\Models\Habit;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class GetHabit
{
    public function __invoke($_, array $args, GraphQLContext $context): ?Habit
    {
        return Habit::with('progresses')->find($args['id']);
    }
}
