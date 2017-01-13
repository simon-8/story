<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable;


    public function lists($condition = [] , $page = 1 , $pagesize = 20)
    {
        $condition = empty($condition) ? ['itemid' ,'>' ,'1'] : $condition;
        return $this->where($condition)->select();
    }
}
