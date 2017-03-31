<?php
/**
 * Note: *
 * User: Liu
 * Date: 2017/3/13
 */
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class BookDetail extends Model
{
    protected $table = 'books_detail';
    protected $fillable = [
        'pid',
        'title',
        //'content',
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
        return $this->select([
            'id',
            'pid',
            'title',
            'created_at',
            'updated_at',
        ])->where( array_merge(['status' => 1],$condition) )->orderBy($order[0] , $order[1])->paginate($pagesize);
    }

    public function updateDetail($data)
    {
        $item = $this->find($data['id']);
        if(!$item) return false;
        $item->title = $data['title'];
        $item->status = $data['status'];
        return $item->save();
    }

    public function nextPage($pid,$aid)
    {
        return $this->select('id')->where('pid' , $pid)->where('id','>',$aid)->orderBy('id','ASC')->first();
    }

    public function prevPage($pid,$aid)
    {
        return $this->select('id')->where('pid' , $pid)->where('id','<',$aid)->orderBy('id','DESC')->first();
    }

    public function lastDetail($pid)
    {
        return $this->select('id','title')->where('pid' , $pid)->orderBy('id','DESC')->first();
    }
}