<?php
/**
 * 管理员相关
 * Created by PhpStorm.
 * User: Liu
 * Date: 2017/1/16
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;

class ManagerController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
        $lists = $this->Manager->lists();
        $data = [
            'lists' => $lists,
        ];
        return admin_view('manager.index' , $data);
    }

    public function getCreate()
    {

    }

    public function postCreate()
    {

    }
}