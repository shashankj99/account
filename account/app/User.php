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

}
