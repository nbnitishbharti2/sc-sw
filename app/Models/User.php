<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    protected $appends = ['session','nextsession','prevsession'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function UserSessionMap()
    {  
        return $this->hasMany("App\Models\UserSessionMap")->where('user_id', '=', Auth::user()->id);
    }

    
    public function getOrgIdAttribute($value)
    {
        return $value;
    }

    public function roles()
    {
        return $this->hasOne('App\Models\UserRole');
    }
     
}
