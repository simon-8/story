<?php
/**
 * Note: 资源库基类
 * User: Liu
 * Date: 2018/4/4
 */
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;
    protected static $pageSize = 15;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function listBy($where, $page = true)
    {
        return $page ? $this->model->where($where)->paginate(self::$pageSize) : $this->model->where($where)->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findBy($field, $value)
    {
        return $this->model->where($field, $value)->first();
    }

    /**
     * 新增
     * @param array $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * 更新
     * @param array $data
     * @return mixed
     */
    public function update($data)
    {
        $item = $this->find($data[$this->model->getKeyName()]);
        return $item->update($data);
    }

    /**
     * 删除
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}