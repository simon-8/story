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
    protected $tag;
    protected $tag_record;

    public function __construct()
    {
        parent::__construct();
        $this->tag = DB::table('tag');
        $this->tag_record = DB::table('tag_record');
    }

    public function tag($tag = '', $id){
        if($tag == '' || $id == '') return;
        $old = array();
        $old_tmp = $this->tag_record->where('aid',$id)->get();
        foreach($old_tmp as $v){
            $old[$v['id']] = $v;
        }
        //单标签
        if( strpos($tag , ',') === false ){
            $t = $this->tag->select('id')->where('name',$tag)->first();
            if(!$t){
                $t['id'] = $this->tag->insertGetId( array('name'=>$tag,'items'=>0,'addtime'=>time(),'status'=>1) );//create tag
            }
            if($t){
                $r = $this->tag_record->where('aid',$id)->where('tid',$t['id'])->first();
                if(!$r){
                    $this->tag->where('id',$t['id'])->increment('items', 1);
                    $id = $this->tag_record->insertGetId(array('aid'=>$id,'tid'=>$t['id']));
                }else{
                    unset($old[$r['id']]);
                }
            }
        }else{
            foreach( explode(',',$tag) as $v ){
                $t = $this->tag->select('id')->where("name",$v)->first();
                if(!$t){
                    $t['id'] = $this->tag->insertGetId( array('name'=>$v,'items'=>0,'addtime'=>time(),'status'=>1) );//create tag
                }
                if($t){
                    $r = $this->tag_record->where('aid',$id)->where('tid',$t['id'])->first();//
                    if(!$r){
                        $this->tag->where('id',$t['id'])->increment('items', 1);
                        $id = $this->tag_record->insertGetId(array('aid'=>$id,'tid'=>$t['id']));
                    }else{
                        unset($old[$r['id']]);
                    }
                }
            }
        }
        if(count($old)){
            foreach($old as $k => $v){
                $this->tag_record->where('id',$k)->delete();
                $this->tag->where('id',$v['tid'])->decrement('items', 1);
            }
        }
    }
}