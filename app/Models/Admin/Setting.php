<?php
/**
 * Note: 系统配置
 * User: Liu
 * Date: 2017/2/7
 */
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'item';//设置自定义主键
    protected $fillable = [
        'item',
        'name',
        'value'
    ];
    public $timestamps = false;//禁止维护timestamps相关字段

    public function lists()
    {
        return $this->all()->toArray();
    }

    /**
     * 新增
     * @param $data
     * @return bool
     */
    public function create_setting($data)
    {
        return $this->updateOrCreate(['item' => $data['item']] , $data);
    }
    /**
     * 保存
     * @param $data
     * @return bool
     */
    public function update_setting($data)
    {
        foreach($data as $k=>$v){
            $r = $this->find($k);
            if(!$r){
                continue;
            }else{
                //$r->name = $v['name'];
                $r->value = $v['value'];
                $r->save();
            }
        }
        return true;
    }

    /**
     * 删除
     * @param $item
     * @return mixed
     */
    public function delete_setting($item)
    {
        return $this->destroy($item);
    }
}