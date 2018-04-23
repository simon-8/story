<?php
/**
 * Note: 小说内容模型
 * User: Liu
 * Date: 2017/3/13
 */
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class BookContent extends Model
{
    protected $table = 'books_content';
    protected $fillable = [
        'id',
        'content',
    ];
    public $timestamps = false;

    /**
     * 获取内容
     * @param $id
     * @return string
     */
    public function getContent($id)
    {
        $data = $this->find($id);
        if($data)
        {
            return $data['content'];
        }
        else
        {
            return '';
        }
    }

    /**
     * 更新内容
     * @param $data
     * @return bool
     */
    public function updateContent($data)
    {
        $item = $this->find($data['id']);
        if(!$item) return false;
        $item->content = $data['content'];
        return $item->save();
    }
}