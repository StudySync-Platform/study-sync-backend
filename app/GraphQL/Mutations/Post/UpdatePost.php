<?php

namespace App\GraphQL\Mutations\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class UpdatePost
{
    public function __invoke($_, array $args, GraphQLContext $context): Post
    {
        $post = Post::findOrFail($args['id']);
        
        // Authorization is handled by @can directive in schema
        // But we can double-check here if needed
        $user = $context->user() ?? Auth::user();
        if ($user->id !== $post->author_id) {
            throw new \Exception('Unauthorized to update this post');
        }
        
        $input = $args['input'];
        
        // Only update provided fields
        if (isset($input['content'])) {
            $post->content = $input['content'];
        }
        
        if (isset($input['media_urls'])) {
            $post->media_urls = $input['media_urls'];
        }
        
        if (isset($input['visibility'])) {
            $post->visibility = $input['visibility'];
        }
        
        $post->save();
        
        return $post->fresh();
    }
}
