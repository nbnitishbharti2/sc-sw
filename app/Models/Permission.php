<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table 	= 'permissions';
    protected $fillable = ['module_id', 'name', 'description','guard_name'];

    public function Roles()
    {
    	return $this->belongsToMany(Role::class, 'role_permission');
    }
    public function RolePermission()
    {
    	return $this->hasMany(RolePermission::class);
    }
}
