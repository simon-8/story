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
    public static function lists()
    {
        $all = self::orderBy('listorder' ,'desc')->get()->toArray();
        $data = [];
        foreach($all as $k=>$v)
        {
            if($v['pid'] == 0)
            {
                $v['url'] = route2url($v['prefix'] . '.' . $v['route']);
                $data[$v['id']] = $v;
                unset($all[$k]);
            }
        }
        foreach($all as $k=>$v)
        {
            $v['url'] = route2url($v['prefix'] . '.' . $v['route']);
            $data[$v['pid']]['child'][$v['id']] = $v;
        }
        return $data;
    }

    /**
     * 获取顶级菜单
     * @return array
     */
    public function get_parent_menus()
    {
        $tmp = $this->where('pid' ,0)->orderBy('listorder','desc')->get()->toArray();
        foreach($tmp as $v)
        {
            $data[$v['id']] = $v;
        }
        return $data;
    }

    /**
     * 创建数据
     * @param $data
     * @return static
     */
    public function create_menu($data)
    {
        if($data['pid'])
        {
            $this->where('id' , $data['pid'])->increment('items' , 1);
        }
        return $this->create($data);
    }

    /**
     * 更新数据
     * @param $data
     * @return bool|int
     */
    public function update_menu($item , $data)
    {
        if($item->pid != $data['pid'])
        {
            $this->where('id' , $data['pid'])->increment('items' , 1);
            $this->where('id' , $item->pid)->decrement('items' , 1);
        }
        return $item->update($data);
    }

    /**
     * 删除菜单及子菜单
     * 后台管理菜单最多两层
     * pid=0的只会是一级菜单，删除一级菜单需要将下面的二级菜单一并删除
     * @param $itemid
     * @return bool
     */
    public function delete_menu($id)
    {
        $item = $this->find($id);
        if($item->pid)
        {
            $this->where('id' , $item->pid)->decrement('items' , 1);
        }
        else
        {
            $this->where('pid' , $id)->delete();
        }
        $this->where('id' , $id)->delete();


        return true;
    }


}
