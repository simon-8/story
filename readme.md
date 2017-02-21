### 安装
git下载本程序后

> 复制配置文件

    复制根目录 .env.example 文件 , 保存为.env文件
    [linux] cp .env.example .env
    
> 修改.env配置文件

     DB_HOST=localhost
     DB_DATABASE=story
     DB_USERNAME=root
     DB_PASSWORD=123456
     
> 通过composer安装程序所需扩展
    
    composer install
    
> 还原数据库备份 , 生成菜单默认管理员等数据
    
    php artisan migrate --seed

> 后台地址
  
    http://你配置的域名/admin
    账号: simon
    密码: 123456