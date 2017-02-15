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
    protected $fillable = [
        'item',
        'name',
        'value'
    ];

    public function lists()
    {
        return $this->all()->toArray();
    }

    /**
     * @param $data
     * @return bool
     */
    public function create_setting($data)
    {
        $r = $this->where("item", $data['item'])->first();
        if (!$r) {
            return $this->insert([
                'item' => $data['item'],
                'name' => $data['name'],
                'value' => $data['value']
            ]);
        } else {
            return false;
        }
    }
    /**
     * 保存
     * @param $data
     * @return bool
     */
    public function update_setting($data)
    {
        foreach($data as $k=>$v){
            $r = $this->where("item",$k)->find();
            if(!$r){
                $this->insert([
                    'item'=>$k,
                    'name'=>$k,
                    'value'=>$v
                ]);
            }else{
                $r->value = $v;
                $r->save();
            }
        }
        return true;
    }

}