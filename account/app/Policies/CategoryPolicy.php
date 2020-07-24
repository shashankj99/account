<?php

namespace App\Policies;

use App\Category;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    // policy to edit or update a category
    public function update(User $user, Category $category) {
        return  $user->email == config('app.admin') || $user->id == $category->user_id;
    }

    // policy to delete a category
    public function delete(User $user, Category $category) {
        return $user->email == config('app.admin') || $user->id == $category->user_id;
    }
}
