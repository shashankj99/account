<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = ['user_id', 'company_id', 'date', 'receipt_no', 'particulars', 'debit', 'credit', 'amount'];
    
    // many to one relation with user
    public function user() {
        return $this->belongsTo(User::class);
    }

    // many to one relation with company
    public function company() {
        return $this->belongsTo(Company::class);
    }
}
