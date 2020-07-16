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
    protected $fillable = ['name', 'reg_no', 'reg_date', 'type', 'user_id'];
    
    // many to one relation with user
    public function user() {
        return $this->belongsTo(User::class);
    }
}
