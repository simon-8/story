### 安装

> git 下载本程序
    
    git clone https://github.com/simon-8/story.git story
    cd story

> 通过composer安装程序所需扩展
    
    composer install

> 运行安装脚本, 按提示输入相关信息
    
    php artisan story:install

![install](https://raw.githubusercontent.com/simon-8/MarkdownPhotos/master/story/install.jpg)


> 修改.env配置文件

    APP_URL=http://域名
    WAP_URL=http://移动站域名
    IMG_URL=http://图片存储二级域名 (选填)
    STATIC_URL=http://静态文件存储路径 (选填)

    # 七牛相关配置 (选填)
    QINIU_ACCESS_KEY=七牛access_key
    QINIU_SECRET_KEY=七牛secret_key
    QINIU_BUCKET_NAME=七牛的空间名称

> 后台地址
  
    http://你配置的域名/pc
    账号: admin
    密码: 123456
    
> 线上部署优化
    
    #配置缓存
    php artisan config:cache
    #路由缓存
    php artisan route:cache
    #类映射加载优化
    php artisan optimize --force