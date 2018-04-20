<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $fillable = [
        'username',
        'password',
        'truename',
        'email',
        'salt',
        'lasttime',
        'lastip',
        'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = password_hash($value , PASSWORD_DEFAULT);
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Admin\RoleGroup', 'groupid', 'id');
    }
}
