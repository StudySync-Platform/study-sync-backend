<?php

namespace App\GraphQL\Mutations\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class DeletePost
{
    public function __invoke($_, array $args, GraphQLContext $context): Post
    {
        $post = Post::findOrFail($args['id']);
        
        // Authorization is handled by @can directive in schema
        $user = $context->user() ?? Auth::user();
        if ($user->id !== $post->author_id) {
            throw new \Exception('Unauthorized to delete this post');
        }
        
        // Return the post before deleting (for client cache updates)
        $deletedPost = $post->replicate();
        $deletedPost->id = $post->id;
        
        $post->delete();
        
        return $deletedPost;
    }
}
