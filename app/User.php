<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {

    use HasApiTokens,
        Notifiable,
        HasRoles;

    protected $fillable = [
        'name', 'last_name', 'email', 'password','profile_picture','identification', 'change_pw',// 'facebook','linkedin','twiter'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
