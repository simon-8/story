<?php

use Illuminate\Database\Seeder;

class AdminMenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menus')->delete();
        
        \DB::table('admin_menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'pid' => 0,
                'name' => '菜单管理',
                'prefix' => 'Menu',
                'route' => 'getIndex',
                'ico' => 'fa fa-list',
                'listorder' => 0,
                'items' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'pid' => 0,
                'name' => '管理员管理',
                'prefix' => 'Manager',
                'route' => 'getIndex',
                'ico' => 'fa fa-users',
                'listorder' => 0,
                'items' => 2,
            ),
            2 => 
            array (
                'id' => 3,
                'pid' => 0,
                'name' => '文章管理',
                'prefix' => 'Article',
                'route' => 'getIndex',
                'ico' => 'fa fa-book',
                'listorder' => 0,
                'items' => 4,
            ),
            3 => 
            array (
                'id' => 4,
                'pid' => 0,
                'name' => '微信管理',
                'prefix' => 'Weixin',
                'route' => 'getIndex',
                'ico' => 'fa fa-wechat',
                'listorder' => 0,
                'items' => 2,
            ),
            4 => 
            array (
                'id' => 5,
                'pid' => 0,
                'name' => '数据管理',
                'prefix' => 'Database',
                'route' => 'getIndex',
                'ico' => 'fa fa-database',
                'listorder' => 0,
                'items' => 0,
            ),
            5 => 
            array (
                'id' => 6,
                'pid' => 0,
                'name' => '前台首页',
                'prefix' => '',
                'route' => '',
                'ico' => 'fa fa-home',
                'listorder' => 99,
                'items' => 0,
            ),
            6 => 
            array (
                'id' => 7,
                'pid' => 0,
                'name' => '后台首页',
                'prefix' => 'Admin',
                'route' => 'getIndex',
                'ico' => 'fa fa-desktop',
                'listorder' => 98,
                'items' => 0,
            ),
            7 => 
            array (
                'id' => 8,
                'pid' => 2,
                'name' => '添加管理员',
                'prefix' => 'Manager',
                'route' => 'getCreate',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            8 => 
            array (
                'id' => 9,
                'pid' => 2,
                'name' => '管理员列表',
                'prefix' => 'Manager',
                'route' => 'getIndex',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            9 => 
            array (
                'id' => 10,
                'pid' => 3,
                'name' => '添加文章',
                'prefix' => 'Article',
                'route' => 'getCreate',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            10 => 
            array (
                'id' => 11,
                'pid' => 3,
                'name' => '文章列表',
                'prefix' => 'Article',
                'route' => 'getIndex',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            11 => 
            array (
                'id' => 12,
                'pid' => 3,
                'name' => '文章分类',
                'prefix' => 'Article',
                'route' => 'getCategorys',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            12 => 
            array (
                'id' => 13,
                'pid' => 3,
                'name' => '回收站',
                'prefix' => 'Article',
                'route' => 'getRecycle',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            13 => 
            array (
                'id' => 14,
                'pid' => 4,
                'name' => '微信用户',
                'prefix' => '',
                'route' => '',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            14 => 
            array (
                'id' => 15,
                'pid' => 4,
                'name' => '微信配置',
                'prefix' => '',
                'route' => '',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            15 => 
            array (
                'id' => 16,
                'pid' => 0,
                'name' => '系统配置',
                'prefix' => 'Setting',
                'route' => 'getIndex',
                'ico' => 'fa fa-cog',
                'listorder' => 0,
                'items' => 3,
            ),
            16 => 
            array (
                'id' => 17,
                'pid' => 16,
                'name' => '站点配置',
                'prefix' => 'Setting',
                'route' => 'getIndex',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            17 => 
            array (
                'id' => 19,
                'pid' => 0,
                'name' => '小说管理',
                'prefix' => 'Book',
                'route' => 'getIndex',
                'ico' => 'fa fa-book',
                'listorder' => 0,
                'items' => 2,
            ),
            18 => 
            array (
                'id' => 20,
                'pid' => 19,
                'name' => '小说列表',
                'prefix' => 'Book',
                'route' => 'getIndex',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            19 => 
            array (
                'id' => 22,
                'pid' => 19,
                'name' => '栏目管理',
                'prefix' => 'Book',
                'route' => 'getCategorys',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            20 => 
            array (
                'id' => 23,
                'pid' => 16,
                'name' => '友情链接',
                'prefix' => 'Setting',
                'route' => 'getFriendLinks',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            21 => 
            array (
                'id' => 24,
                'pid' => 16,
                'name' => '图片上传',
                'prefix' => 'Setting',
                'route' => 'getImageUpload',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
        ));
        
        
    }
}
