<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LedgerEntry extends Model
{
    protected $fillable = ['user_id', 'ledger_account_id', 'date', 'particulars', 'qty', 'debit', 'credit', 'amount'];

     // many to one relation with user
     public function user() {
        return $this->belongsTo(User::class);
    }

    // many to one relation with account
    public function ledgerAccount() {
        return $this->belongsTo(LedgerAccount::class);
    }
}
