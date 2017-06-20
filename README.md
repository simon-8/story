### 安装

git下载本程序后

> 复制配置文件

    复制根目录 .env.example 文件 , 保存为.env文件
    [linux] cp .env.example .env
    
> 修改.env配置文件

````bash
    DB_HOST=localhost
    DB_DATABASE=story
    DB_USERNAME=root
    DB_PASSWORD=123456
    
    STATIC_DOMAIN=http://静态文件存储二级域名
    PICTURE_DOMAIN=http://图片存储二级域名
    APP_MOBILE_DOMAIN=http://移动站域名
````

> 修改七牛云存储配置

    config/upload.php为七牛云存储相关配置。
    
> 通过composer安装程序所需扩展
    
    composer install
    
> 生成应用程序密钥

    php artisan key:generate

> 还原数据库备份 , 生成菜单 , 默认管理员等数据
    
    php artisan migrate --seed

> 后台地址
  
    http://你配置的域名/pc
    账号: simon
    密码: 123456
    
> 线上部署优化
    
    #配置缓存
    php artisan config:cache
    #路由缓存
    php artisan route:cache
    #类映射加载优化
    php artisan optimize --force