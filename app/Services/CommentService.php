<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Log;

class CommentService
{
    public function createComment(Post $post, array $data, int $userId)
    {
        try {

            $post->comments()->create([
                'content' => $data['content'],
                'name' => $data['name'],
                'email' => $data['email'],
                'user_id' => $userId,
            ]);

            return true;

        } catch (\Exception $e) {

            Log::error('Error storing comment: ' . $e->getMessage());

            return false;

        }

    }

}
