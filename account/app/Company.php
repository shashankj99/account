<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 *
 * @package App
 * @author Shashank Jha shashankj677@gmail.com
 */

class Company extends Model
{
    protected $fillable = ['name', 'reg_no', 'reg_date', 'address', 'contact_no', 'type', 'user_id'];
    
    // many to one relation with user
    public function user() {
        return $this->belongsTo(User::class);
    }

    // one to many relation with sales
    public function sales() {
        return $this->hasMany(Sales::class);
    }

    // one to many relation with purchase
    public function purchases() {
        return $this->hasMany(Purchase::class);
    }

    // one to many relation with ledger accounts
    public function ledgerAccounts() {
        return $this->hasMany(LedgerAccount::class);
    }

    // one to many relation with receipt
    public function receipts() {
        return $this->hasMany(Receipt::class);
    }

    // one to many relation with payment
    public function payments() {
        return $this->hasMany(Payment::class);
    }

    // one to many relation with debit
    public function debits() {
        return $this->hasMany(Debit::class);
    }

    // one to many relation with credit
    public function credits() {
        return $this->hasMany(Credit::class);
    }
}
