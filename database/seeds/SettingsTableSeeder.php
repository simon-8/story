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
                'item' => 'title',
                'name' => '网站标题',
                'value' => 'Laravel小说站',
            ),
            1 => 
            array (
                'item' => 'keywords',
                'name' => '网站关键词',
                'value' => 'Simon,刘文静,程序开发,自学php,php技巧,destoon模板,thinkphp教程,二次开发,nginx,redis,sphinx,coreseek,搜索引擎,开发',
            ),
            2 => 
            array (
                'item' => 'description',
                'name' => '网站简介',
                'value' => '爱编程,更爱生活,多年php项目经验,用技术说话.我是Simon [刘文静] -----我喂自己袋盐',
            ),
            3 => 
            array (
                'item' => 'icp',
                'name' => '网站备案号',
                'value' => '皖ICP备15001767号',
            ),
            4 => 
            array (
                'item' => 'powerby',
                'name' => '网站版权',
                'value' => 'Power By Simon',
            ),
            5 => 
            array (
                'item' => 'admin_email',
                'name' => '管理员邮箱',
                'value' => 'liu@simon8.com',
            ),
            6 => 
            array (
                'item' => 'oauth_qq_appid',
                'name' => 'QQ登录APP ID',
                'value' => '101343019',
            ),
            7 => 
            array (
                'item' => 'oauth_qq_appkey',
                'name' => 'QQ互联APP KEY',
                'value' => '8c975059d21cfb6cab0a5ae57be79c68',
            ),
        ));
        
        
    }
}
