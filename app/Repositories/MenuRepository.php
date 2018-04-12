<?php
/**
 * Note: 菜单资源库
 * User: Liu
 * Date: 2018/4/12
 */

namespace App\Repositories;

use App\Models\Admin\Menu;

class MenuRepository extends BaseRepository
{
    public function __construct(Menu $model)
    {
        parent::__construct($model);
    }

    /**
     * @return array
     */
    public static function lists()
    {
        $all = (new Menu())->orderBy('listorder', 'desc')->get()->toArray();
        $data = [];
        foreach ($all as $k => $v) {
            if ($v['pid'] == 0) {
                if ($v['prefix']) {
                    $v['url'] = route2url($v['prefix'] . '.' . $v['route']);
                } else {
                    $v['url'] = route2url($v['route']);
                }
                $data[$v['id']] = $v;
                unset($all[$k]);
            }
        }
        foreach ($all as $k => $v) {
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
        $tmp = $this->model->where('pid', 0)->orderBy('listorder', 'desc')->get()->toArray();
        foreach ($tmp as $v) {
            $data[$v['id']] = $v;
        }
        return $data;
    }

    public function create_menu($data)
    {
        if ($data['pid']) {
            $this->model->where('id', $data['pid'])->increment('items', 1);
        }
        return $this->create($data);
    }

    /**
     * 更新数据
     * @param $data
     * @return bool|int
     */
    public function update_menu($item, $data)
    {
        if ($item->pid != $data['pid']) {
            $this->model->where('id', $data['pid'])->increment('items', 1);
            $this->model->where('id', $item->pid)->decrement('items', 1);
        }
        return $item->update($data);
    }

    /**
     * 删除菜单及子菜单
     * 后台管理菜单最多两层
     * pid=0的只会是一级菜单，删除一级菜单需要将下面的二级菜单一并删除
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function delete_menu($id)
    {
        $item = $this->find($id);
        if ($item->pid) {
            $this->model->where('id', $item->pid)->decrement('items', 1);
        } else {
            $this->model->where('pid', $id)->delete();
        }
        $this->model->where('id', $id)->delete();

        return true;
    }
}