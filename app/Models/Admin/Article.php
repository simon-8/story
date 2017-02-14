<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'catid',
        'title',
        'introduce',
        'tag',
        'content',
        'thumb',
        'username',
        'comment',
        'zan',
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
    public function lists($condition = [] , $order = 'id DSEC',$pagesize = 20)
    {
        $order = $order ? explode(' ' , $order) : ['id' ,'DESC'];
        return $this->where( array_merge(['status' => 1],$condition) )->orderBy($order[0] , $order[1])->paginate($pagesize);
    }


    /**
     * 创建文章
     * @param $data
     * @return static
     */
    public function create_article($data)
    {
        $data['introduce'] = mb_substr(strip_tags($data['content']) , 0 ,50);
        return $this->create($data);
    }

    /**
     * 更新文章
     * @param $data
     * @return bool|int
     */
    public function update_article($data)
    {
        $article = $this->find($data['id']);
        if(!$article) return false;
        return $article->update($data);
    }

    /**
     * 回收站
     * @return bool
     */
    public function recycle()
    {
        $this->status = 2;
        return $this->save();
    }

    /**
     * 获取各个状态的文章数量
     * @return array
     */
    public function get_status_num()
    {
        $data = [];
        $data['0'] = $this->where('status',0)->count();
        $data['1'] = $this->where('status',1)->count();
        $data['2'] = $this->where('status',2)->count();
        return $data;
    }
}
