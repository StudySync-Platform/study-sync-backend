<?php

namespace App\GraphQL\Mutations\Habit;

use App\Models\Habit;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UpdateHabit
{
    public function __invoke($_, array $args, GraphQLContext $context): Habit
    {
        $user = $context->user() ?? Auth::user();
        if (!$user) {
            throw new UnauthorizedHttpException('Bearer', 'Unauthenticated.');
        }

        $habit = Habit::findOrFail($args['id']);

        if ($habit->user_id !== $user->id) {
            throw new UnauthorizedHttpException('Bearer', 'Forbidden.');
        }

        $input = $args['input'];

        if (isset($input['name'])) $habit->name = $input['name'];
        if (array_key_exists('description', $input)) $habit->description = $input['description'];
        if (array_key_exists('target', $input)) $habit->target = $input['target'];
        if (array_key_exists('unit', $input)) $habit->unit = $input['unit'];
        if (array_key_exists('visibility', $input)) $habit->visibility = $input['visibility'];

        $habit->save();

        return $habit->fresh();
    }
}
