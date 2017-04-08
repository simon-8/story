<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'item' => 'admin_email',
                'name' => '管理员邮箱',
                'value' => 'liu@simon8.com',
            ),
            1 => 
            array (
                'item' => 'description',
                'name' => '网站简介',
                'value' => '天下书屋网免费为您提供小说在线阅读服务，没有弹窗广告。为大家分享优质小说！',
            ),
            2 => 
            array (
                'item' => 'icp',
                'name' => '网站备案号',
                'value' => '皖ICP备15001767号',
            ),
            3 => 
            array (
                'item' => 'keywords',
                'name' => '网站关键词',
                'value' => '天下书屋网,免费小说,无弹窗',
            ),
            4 => 
            array (
                'item' => 'oauth_qq_appid',
                'name' => 'QQ登录APP ID',
                'value' => '101343019',
            ),
            5 => 
            array (
                'item' => 'oauth_qq_appkey',
                'name' => 'QQ互联APP KEY',
                'value' => '8c975059d21cfb6cab0a5ae57be79c68',
            ),
            6 => 
            array (
                'item' => 'powerby',
                'name' => '网站版权',
                'value' => 'Copyright © 2017 天下书屋网 All Rights Reserved.',
            ),
            7 => 
            array (
                'item' => 'title',
                'name' => '网站标题',
                'value' => '天下书屋 - 无弹窗小说阅读网',
            ),
        ));
        
        
    }
}
