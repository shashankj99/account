<?php

namespace App\Policies;

use App\Company;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    // policy to delete a company
    public function delete(User $user, Company $company) {
        return $user->email == config('app.admin');
    }
}
