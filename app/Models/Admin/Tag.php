<?php
/**
 * Note: 标签
 * User: Liu
 * Date: 2017/2/6
 */
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

use DB;

class Tag extends Model
{
    protected $TagTable;
    protected $TagRecordTable;

    public function __construct()
    {
        parent::__construct();
        $this->TagTable = DB::table('tag');
        $this->TagRecordTable = DB::table('tag_record');
    }

    /**
     * 创建标签
     * @param string $tag
     * @param $id
     */
    public function create_tag($tag = '', $id){
        if($tag == '' || $id == '') return;
        $old = array();

        $old_tmp = $this->TagRecordTable->where('aid',$id)->get();
        foreach($old_tmp as $v){
            $v = (Array) $v;
            $old[$v['id']] = $v;
        }
        //单标签
        if( strpos($tag , ',') === false ){
            $t = (Array) $this->TagTable->select('id')->where('name',$tag)->first();
            if(!$t){
                $t['id'] = $this->TagTable->insertGetId( array('name'=>$tag,'items'=>0,'addtime'=>time(),'status'=>1) );//create tag
            }
            if($t){
                $r = (Array) $this->TagRecordTable->where('aid',$id)->where('tid',$t['id'])->first();
                if(!$r){
                    $this->TagTable->where('id',$t['id'])->increment('items', 1);
                    $id = $this->TagRecordTable->insertGetId(array('aid'=>$id,'tid'=>$t['id']));
                }else{
                    unset($old[$r['id']]);
                }
            }
        }else{
            foreach( explode(',',$tag) as $v ){
                $t = (Array) $this->TagTable->select('id')->where("name",$v)->first();

                if(!$t){
                    $t['id'] = $this->TagTable->insertGetId( array('name'=>$v,'items'=>0,'addtime'=>time(),'status'=>1) );//create tag
                }
                if($t){
                    $r = (Array) $this->TagRecordTable->where('aid',$id)->where('tid',$t['id'])->first();//
                    if(!$r){
                        $this->TagTable->where('id',$t['id'])->increment('items', 1);
                        $id = $this->TagRecordTable->insertGetId(array('aid'=>$id,'tid'=>$t['id']));
                    }else{
                        unset($old[$r['id']]);
                    }
                }
            }
        }
        if(count($old)){
            foreach($old as $k => $v){
                $this->TagRecordTable->where('id',$k)->delete();
                $this->TagTable->where('id',$v['tid'])->decrement('items', 1);
            }
        }
    }

    /**
     * 获取标签列表
     * @return array|static[]
     */
    public function lists()
    {
        return $this->TagTable->get();
    }
}