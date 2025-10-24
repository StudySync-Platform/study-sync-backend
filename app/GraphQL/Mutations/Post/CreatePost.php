<?php

namespace App\GraphQL\Mutations\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CreatePost
{
    public function __invoke($_, array $args, GraphQLContext $context): Post
    {
        $user = $context->user() ?? Auth::user();
        if (! $user) {
            throw new UnauthorizedHttpException('Bearer', 'Unauthenticated.');
        }

        $input = $args['input'];

        $post = new Post();
        $post->author_id  = $user->id;
        $post->room_id    = $input['room_id'] ?? null;
        $post->content    = $input['content'];
        $post->media_urls = $input['media_urls'] ?? null;
        $post->visibility = $input['visibility'];
        $post->type       = $input['type'];
        $post->save();

        return $post->fresh();
    }
}
