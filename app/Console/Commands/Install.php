<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'story:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto install';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $dbhost = $this->ask('请输入数据库地址', 'localhost');
        $dbname = $this->ask('请输入数据库名称', 'story');
        $dbuser = $this->ask('请输入数据库用户名', 'homestead');
        $dbpass = $this->ask('请输入数据库密码', false);
        // ash 不允许空值
        $dbpass = $dbpass ? $dbpass : '';

        $envExample = \File::get(base_path('.env.example'));
        $search = [
            'DB_HOST=localhost',
            'DB_DATABASE=homestead',
            'DB_USERNAME=homestead',
            'DB_PASSWORD=secret'
        ];
        $replace = [
            'DB_HOST='.$dbhost,
            'DB_DATABASE='.$dbname,
            'DB_USERNAME='.$dbuser,
            'DB_PASSWORD='.$dbpass
        ];
        $env = str_replace($search, $replace, $envExample);
        $saveResult = \File::put(base_path('.env'), $env);
        if (!$saveResult) {
            $this->error("配置生成失败");
            return;
        }
        $this->info("配置生成成功");

        $this->call('migrate', [
            '--seed' => true
        ]);
        $this->info("数据库还原成功");

        $this->call('key:generate');

        $this->info('*************** 安装完成 ***************');
        $this->info('* 请配置env中APP_URL WAP_URL 确保程序正常工作 *');
        $this->info('************ 请尽快修改密码 ***************');
        $this->line('后台链接：http://你的域名/pc');
        $this->line('用户名：admin ');
        $this->line('密码：123456 ');

    }
}
