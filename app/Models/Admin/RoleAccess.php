<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/4/20
 */
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    public $fillable = [
        'pid',
        'name',
        'path'
    ];

    public function child()
    {
        return $this->hasMany('App\Models\Admin\RoleAccess', 'pid', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Modles\Admin\RoleAccess', 'pid', 'id');
    }
}