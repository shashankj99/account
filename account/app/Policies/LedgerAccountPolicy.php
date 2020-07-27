<?php

namespace App\Policies;

use App\LedgerAccount;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LedgerAccountPolicy
{
    use HandlesAuthorization;

    // policy to delete a ledger account
    public function delete(User $user, LedgerAccount $ledgerAccount) {
        return $user->email == config('app.admin');
    }
}
