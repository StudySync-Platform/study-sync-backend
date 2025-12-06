<?php

namespace App\GraphQL\Mutations\Habit;

use App\Models\Habit;
use App\Models\HabitProgress;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class PublishHabitAsPost
{
    public function __invoke($_, array $args, GraphQLContext $context): Post
    {
        $user = $context->user() ?? Auth::user();
        if (!$user) {
            throw new UnauthorizedHttpException('Bearer', 'Unauthenticated.');
        }

        $input = $args['input'];

        $habit = Habit::findOrFail($input['habit_id']);

        $content = '';
        $habitProgressCount = $habit->progresses()->count();

        if (!empty($input['progress_id'])) {
            $progress = HabitProgress::findOrFail($input['progress_id']);
            $content = sprintf(
                "Updated habit '%s' — %s %s on %s",
                $habit->name,
                $progress->value,
                $habit->unit ?? 'units',
                $progress->progress_date->toDateString()
            );
        } else {
            $content = sprintf("Started habit '%s' — %s", $habit->name, $habit->description ?? '');
        }

        $post = new Post();
        $post->author_id = $user->id;
        $post->content = $content;
        $post->visibility = $input['visibility'] ?? 'public';
        $post->type = $input['type'] ?? 'habit';
        $post->media_urls = [
            'habit_id' => $habit->id,
            'habit_name' => $habit->name,
            'habit_description' => $habit->description ?? '',
            'habit_progress_count' => $habitProgressCount,
            'progress_id' => $input['progress_id'] ?? '',
        ];

        $post->save();

        return $post->fresh();
    }
}
