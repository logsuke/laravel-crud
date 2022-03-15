<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
     use HandlesAuthorization;

     public function before(User $user, $ability)
     {
          $user_policy = new UserPolicy;
          if ($user_policy->isAdmin($user)) {
               return true;
          }
     }

     public function edit(User $user, Post $post)
     {
          return $user->id == $post->user_id;
     }
}
