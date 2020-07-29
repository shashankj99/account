<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * @package App
 * @author Shashank Jha shashankj677@gmail.com
 */

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'mobile', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // one to many relation with company
    public function companies() {
        return $this->hasMany(Company::class);
    }

    // one to many relation with category
    public function categories() {
        return $this->hasMany(Category::class);
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

    // one to many relation with ledger entries
    public function ledgerEntries() {
        return $this->hasMany(LedgerEntry::class);
    }

    // one to many relation with receipt
    public function receipts() {
        return $this->hasMany(Receipt::class);
    }

    // one to many relation with payment
    public function payments() {
        return $this->hasMany(Payment::class);
    }

    // one to many relation with payment
    public function debits() {
        return $this->hasMany(Debit::class);
    }
}
