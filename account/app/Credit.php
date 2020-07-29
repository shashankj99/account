<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = ['user_id', 'company_id', 'date', 'credit_note_no', 'qty', 'amount'];

    // many to one relation with user
    public function user() {
        return $this->belongsTo(User::class);
    }

    // many to one relation with company
    public function company() {
        return $this->belongsTo(Company::class);
    }
}
