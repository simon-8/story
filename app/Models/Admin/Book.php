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
    ];

    /**
     * 获取列表
     * @param array $condition
     * @param string $order
     * @param int $page
     * @param int $pagesize
     * @return mixed
     */
    public function lists($condition = [] , $order = 'id DSEC',$pagesize = 10)
    {
        $order = $order ? explode(' ' , $order) : ['id' ,'DESC'];
        return $this->where( array_merge(['status' => 1],$condition) )->orderBy($order[0] , $order[1])->paginate($pagesize);
    }

}