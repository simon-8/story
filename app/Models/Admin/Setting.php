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
        'value'
    ];

    public function batch_save($data)
    {
        foreach($data as $k=>$v){
            $r = $this->where("item",$k)->find();
            if(!$r){
                $this->insert([
                    'item'=>$k,
                    'value'=>$v
                ]);
            }else{
                $r->value = $v;
                $r->save();
            }
        }
    }

}