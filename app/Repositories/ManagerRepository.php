<?php
/**
 * Note: 管理员资源管理器
 * User: Liu
 * Date: 2018/4/12
 */
namespace App\Repositories;

use App\Models\Admin\Manager;


class ManagerRepository extends BaseRepository
{
    public function __construct(Manager $model)
    {
        parent::__construct($model);
    }

    /**
     * 根据username查找用户
     * @param $username
     * @return mixed
     */
    public function findByUsername($username)
    {
        return $this->where('username' , $username)->first();
    }

    /**
     * 密码加密
     * @param $password
     * @return bool|string
     */
    protected function encypt_password($password)
    {
        return password_hash($password , PASSWORD_DEFAULT);
    }

    /**
     * 密码校验
     * @param $input_password
     * @param $password
     * @return bool
     */
    public function compare_password($input_password , $password)
    {
        return password_verify($input_password , $password);
    }

    /**
     * 存储在session中的password
     * @param $password
     * @return string
     */
    public function session_use_password($password)
    {
        return substr(md5($password) ,0 ,8);
    }

    /**
     * 获取列表
     * @param array $condition
     * @param string $order
     * @param int $page
     * @param int $pagesize
     * @return mixed
     */
    public function lists($condition = [] , $order = 'id DSEC', $page = 1 , $pagesize = 20)
    {
        $order = $order ? explode(' ' , $order) : ['id' ,'DESC'];
        return $this->model->where($condition)->orderBy($order[0] , $order[1])->get();
    }
}