<?php

namespace Blog\Policies;

use Blog\User;
use Blog\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function pass(User $user, Post $post){
        return $user->id == $post->user_id;
    }
}
