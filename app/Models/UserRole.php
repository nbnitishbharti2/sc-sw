<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_roles';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'role_id'
    ];

    public function Role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getRoleAttribute()
    {
        return $this->belongsTo(Role::class, 'role_id')->first();
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

}
