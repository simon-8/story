<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'admin_menus';
    protected $fillable = [
        'pid',
        'name',
        'prefix',
        'route',
        'ico',
        'listorder',
    ];
    public $timestamps = false;
}
