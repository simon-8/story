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


    /**
     * 获取菜单列表
     * @param array $condition
     * @param int $page
     * @param int $pagesize
     * @return mixed
     */
    public function lists($condition = [] , $page = 1 , $pagesize = 20)
    {
        $condition = empty($condition) ? ['id' ,'>' ,'0'] : $condition;
        return $this->where('id' ,'>' ,0)->get();
    }


    public function create_menu($data)
    {
        return $this->create($data);
    }

    public function update_menu($data)
    {
        return $this->update($data);
    }

    /**
     * 删除菜单及子菜单
     * @param $itemid
     * @return bool
     */
    public function delete_menu($itemid)
    {
        $this->where('id' , $itemid)->delete();
        $this->where('pid' , $itemid)->delete();
        return true;
    }
}
