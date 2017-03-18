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
        'zhangjie',
        'author',
        'wordcount',
        'follow',
        'hits',
        'status',
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
    public function lists($condition = [] , $order = 'id DSEC',$pagesize = 20)
    {
        $order = $order ? explode(' ' , $order) : ['id' ,'DESC'];
        return $this->where( array_merge(['status' => 1],$condition) )->orderBy($order[0] , $order[1])->paginate($pagesize);
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

}