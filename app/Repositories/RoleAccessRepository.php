<?php
/**
 * Note: 权限资源类
 * User: Liu
 * Date: 2018/4/20
 */
namespace App\Repositories;

use App\Models\Admin\RoleAccess;

class RoleAccessRepository extends BaseRepository
{
    public function __construct(RoleAccess $model)
    {
        parent::__construct($model);
    }
}