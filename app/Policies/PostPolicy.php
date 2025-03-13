<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id == $post->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id == $post->user_id;
    }

    public function vote(User $user, Post $post): bool
    {
        // Check if user is the post creator
        if ($post->user_id === $user->id) {
            return false;
        }
    
        // Check if user has already voted on this post via database query
        return !$post->choices()
            ->whereHas('votes', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->exists();
    }
}