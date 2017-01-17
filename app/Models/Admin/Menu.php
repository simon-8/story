<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable;


    /**
     * 获取菜单列表
     * @param array $condition
     * @param int $page
     * @param int $pagesize
     * @return mixed
     */
    public function lists($condition = [] , $page = 1 , $pagesize = 20)
    {
        $condition = empty($condition) ? ['itemid' ,'>' ,'1'] : $condition;
        return $this->where($condition)->select();
    }


    public function create_menu($data)
    {

    }

    public function update_menu($data)
    {

    }

    /**
     * 删除菜单及子菜单
     * @param $itemid
     * @return bool
     */
    public function delete_menu($itemid)
    {
        $this->where('itemid' , $itemid)->delete();
        $this->where('pid' , $itemid)->delete();
        return true;
    }
}
