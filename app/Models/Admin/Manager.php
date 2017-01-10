<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $fillable = [
        'username',
        'password',
        'salt',
        'lasttime',
        'lastip',
        'remember_token',
    ];

//    protected $attributes = [
//        'username'  => '用户名',
//        'password'  => '密码',
//        'salt'      => '加点盐',
//        'lasttime'  => '最后登录时间',
//        'lastip'    => '最后登录ip',
//        'remember_token'    => '记住我',
//    ];

    /**
     * 添加用户
     * @param $data
     * @return static
     */
    public function create_manager($data)
    {
        $data['password'] = $this->encypt_password($data['password']);
        return $this->create($data);
    }

    /**
     * 更新用户
     * @param $data
     * @return bool|int
     */
    public function update_manager($data)
    {
        return $this->update($data);
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
     * 根据username查找用户
     * @param $username
     * @return mixed
     */
    public function findByUsername($username)
    {
        return $this->where('username' , $username)->first();
    }

    /**
     * 密码校验
     * @param $input_password
     * @param $password
     * @return bool
     */
    public function compare_password($input_password , $password)
    {
        return (password_verify($input_password , PASSWORD_DEFAULT) == $password);
    }
}
