<?php
/**
 * Note: 友情链接
 * User: Liu
 * Date: 2017/3/31
 */
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
class Links extends Model
{
    protected $fillable = [
        'title',
        'linkurl',
        'listorder',
        'status',
    ];

    public function lists($condition = [] , $order = 'listorder DSEC',$pagesize = 20)
    {
        $order = $order ? explode(' ' , $order) : ['listorder' ,'DESC'];
        return $this->where( array_merge(['status' => 1],$condition) )->orderBy($order[0] , $order[1])->paginate($pagesize);
    }
}