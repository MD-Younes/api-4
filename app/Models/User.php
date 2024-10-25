<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'about_me',
        'profile_image',
        'website_link',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    public function projects() {
        return $this->hasMany(Project::class);
    }
}


