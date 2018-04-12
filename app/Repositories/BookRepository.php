<?php
/**
 * Note: 书本资源库
 * User: Liu
 * Date: 2018/4/12
 */
namespace App\Repositories;

use App\Models\Admin\Book;

class BookRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Book());
    }

    /**
     * 普通列表
     * @param array $condition
     * @param string $order
     * @param int $pagesize
     * @param bool $page
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator|static[]
     */
    public function lists($condition = [] , $order = 'id DSEC', $pagesize = 10, $page = true)
    {
        $lists = $this->model->where(array_merge(['status' => 1], $condition));
        if (strpos($order, ',') !== false) {
            foreach (explode(',', $order) as $v) {
                $tmp = explode(' ', $order);
                $lists->orderBy($tmp[0], $tmp[1]);
            }
        } else {
            $order = $order ? explode(' ', $order) : ['id', 'DESC'];
            $lists->orderBy($order[0], $order[1]);
        }
        if ($page) {
            return $lists->paginate($pagesize);
        } else {
            return $lists->take($pagesize)->get();
        }
    }

    /**
     * 封面推荐
     * @param array $condition
     * @param string $order
     * @param int $pagesize
     * @param bool $page
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator|static[]
     */
    public function ftlists($condition = [] , $order = 'id DSEC', $pagesize = 10, $page = false)
    {
        $order = $order ? explode(' ' , $order) : ['id' ,'DESC'];
        $lists = $this->model->where('thumb','<>','')->where( array_merge(['status' => 1],$condition) )->orderBy($order[0] , $order[1]);
        if($page){
            return $lists->paginate($pagesize);
        }else{
            return $lists->take($pagesize)->get();
        }
    }

    /**
     * 获取源列表
     * @param null $status
     * @return array|mixed
     */
    public static function sourceLists($status = null)
    {
        $source = config('book.source');
        if ($status === null) {
            return $source;
        } else if ($status == 1) {
            $source = array_filter($source, function ($v) {
                if ($v['status'] == 1) return true;
            });
        } else if ($status == 0) {
            $source = array_filter($source, function ($v) {
                if ($v['status'] == 0) return true;
            });
        }
        return $source;
    }

    /**
     * @return mixed
     */
    public static function getCategorys()
    {
        return config('book.categorys');
    }
}