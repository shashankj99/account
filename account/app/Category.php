<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'user_id'];

    // many to one relation with user
    public function user() {
        return $this->belongsTo(User::class);
    }
}
