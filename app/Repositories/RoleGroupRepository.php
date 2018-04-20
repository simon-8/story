<?php
/**
 * Note: 权限组资源类
 * User: Liu
 * Date: 2018/4/20
 */
namespace App\Repositories;

use App\Models\Admin\RoleGroup;

class RoleGroupRepository extends BaseRepository
{
    public function __construct(RoleGroup $model)
    {
        parent::__construct($model);
    }
}