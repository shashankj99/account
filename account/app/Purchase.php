<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['user_id', 'company_id', 'invoice_no', 'invoice_date', 'amount', 'type'];
    
    // many to one relation with user
    public function user() {
        return $this->belongsTo(User::class);
    }

    // many to one relation with company
    public function company() {
        return $this->belongsTo(Company::class);
    }
}
