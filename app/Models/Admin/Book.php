<?php
/**
 * Note: *
 * User: Liu
 * Date: 2017/3/13
 */
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'catid',
        'title',
        'introduce',
        'thumb',
        'zhangjie',
        'author',
        'wordcount',
        'level',
        'follow',
        'hits',
        'status',
        'source',
        'fromurl',
        'fromhash',
    ];

    /**
     * 获取列表
     * @param array $condition
     * @param string $order
     * @param int $page
     * @param int $pagesize
     * @return mixed
     */
    public function lists($condition = [] , $order = 'id DSEC',$pagesize = 10,$page = true)
    {
        $lists = $this->where( array_merge(['status' => 1],$condition) );
        if(strpos($order,',') !== false){
            foreach(explode(',' , $order) as $v){
                $tmp = explode(' ' , $order);
                $lists->orderBy($tmp[0] , $tmp[1]);
            }
        }else{
            $order = $order ? explode(' ' , $order) : ['id' ,'DESC'];
            $lists->orderBy($order[0] , $order[1]);
        }
        if($page){
            return $lists->paginate($pagesize);
        }else{
            return $lists->take($pagesize)->get();
        }
    }

    /**
     * 获取列表
     * @param array $condition
     * @param string $order
     * @param int $pagesize
     * @param boolean $page
     * @return mixed
     */
    public function ftlists($condition = [] , $order = 'id DSEC',$pagesize = 10,$page = false)
    {
        $order = $order ? explode(' ' , $order) : ['id' ,'DESC'];
        $lists = $this->where('thumb','<>','')->where( array_merge(['status' => 1],$condition) )->orderBy($order[0] , $order[1]);
        if($page){
            return $lists->paginate($pagesize);
        }else{
            return $lists->take($pagesize)->get();
        }
    }

    /**
     * 更新
     * @param $data
     * @return bool
     */
    public function updateBook($data)
    {
        $item = $this->find($data['id']);
        if(!$item) return false;
        foreach($data as $k => $v){
            if(isset($item->$k)){
                $item->$k = $v;
            }
        }
        return $item->save();
    }

    /**
     * 删除
     * @param $id
     * @return mixed
     */
    public function deleteBook($id)
    {
        $item = $this->find($id);
        $item->status = 0;
        return $item->save();
    }


    /**
     * 获取源列表
     * @param null $status
     * @return array|mixed
     */
    public static function sourceLists($status = null)
    {
        $source = config('book.source');
        if($status === null){
            return $source;
        }else if($status == 1){
            return array_filter($source , function($v){
                if($v['status'] == 1) return true;
            });
        }else if($status == 0){
            return array_filter($source , function($v){
                if($v['status'] == 0) return true;
            });
        }
    }
}