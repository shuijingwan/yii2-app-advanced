安装(多域名)
===

## 要求

- 此项目模板的最低要求是您的Web服务器支持PHP 7.1.0。 
- 必需的PHP扩展：
    - intl
    - gd
    - mcrypt
- php.ini：
    - allow_url_fopen = On
- MySQL 5.7.7 之前的版本：
    - innodb_large_prefix=1
    - innodb_file_format=BARRACUDA

## Git仓库
```
git clone https://github.com/shuijingwan/yii2-app-advanced.git
```

## 安装 Composer 依赖项
```
composer install
```

## 准备应用程序

安装应用程序后，必须执行以下步骤来初始化已安装的应用程序。 这些操作仅需执行一次即可。

1. 打开控制台终端，执行 `init` 命令并选择 `dev` 作为环境。

    ```
    /path/to/php-bin/php /path/to/yii-application/init
    ```
    
    如果使用脚本自动化，可以在非交互模式下执行 `init` 。
    
    ```
    /path/to/php-bin/php /path/to/yii-application/init --env=Production --overwrite=All
    ```

2. 创建一个新的数据库，并相应地调整 `common/config/main-local.php` 中的 `components['db']` 配置。

3. 打开控制台终端，执行迁移命令 
    ```
    /path/to/php-bin/php /path/to/yii-application/yii migrate --migrationPath=@yii/log/migrations/
    /path/to/php-bin/php /path/to/yii-application/yii migrate
    ```

4. 设置Web服务器的文档根目录：

    - 对于接口 `/path/to/yii-application/api/web/` 并且使用URL `http://api.test/`
    - 对于前端 `/path/to/yii-application/frontend/web/` 并且使用URL `http://frontend.test/`
    - 对于后端 `/path/to/yii-application/backend/web/` 并且使用URL `http://backend.test/`
    - 对于远程过程调用 `/path/to/yii-application/rpc/web/` 并且使用URL `http://rpc.test/`
    
    对于Apache，使用如下配置：

    ```
    <VirtualHost *:80>
        ServerName api.test
        DocumentRoot "/path/to/yii-application/api/web/"
        
        <Directory "/path/to/yii-application/api/web/">
            # use mod_rewrite for pretty URL support
            RewriteEngine on
            # If a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # Otherwise forward the request to index.php
            RewriteRule . index.php
            
            # use index.php as index file
            DirectoryIndex index.php
            
            # ...other settings...
        </Directory>
    </VirtualHost>
    
    <VirtualHost *:80>
        ServerName frontend.test
        DocumentRoot "/path/to/yii-application/frontend/web/"
        
        <Directory "/path/to/yii-application/frontend/web/">
            # use mod_rewrite for pretty URL support
            RewriteEngine on
            # If a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # Otherwise forward the request to index.php
            RewriteRule . index.php
            
            # use index.php as index file
            DirectoryIndex index.php
            
            # ...other settings...
        </Directory>
    </VirtualHost>
    
    <VirtualHost *:80>
        ServerName backend.test
        DocumentRoot "/path/to/yii-application/backend/web/"
        
        <Directory "/path/to/yii-application/backend/web/">
            # use mod_rewrite for pretty URL support
            RewriteEngine on
            # If a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # Otherwise forward the request to index.php
            RewriteRule . index.php
            
            # use index.php as index file
            DirectoryIndex index.php
            
            # ...other settings...
        </Directory>
    </VirtualHost>
    
    <VirtualHost *:80>
        ServerName rpc.test
        DocumentRoot "/path/to/yii-application/rpc/web/"
        
        <Directory "/path/to/yii-application/rpc/web/">
            # use mod_rewrite for pretty URL support
            RewriteEngine on
            # If a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # Otherwise forward the request to index.php
            RewriteRule . index.php
            
            # use index.php as index file
            DirectoryIndex index.php
            
            # ...other settings...
        </Directory>
    </VirtualHost>
    ```
    
    Nginx使用如下配置：
    
    ```
    server {
        charset utf-8;
        client_max_body_size 128M;
        
        listen 80; ## listen for ipv4
        #listen [::]:80 default_server ipv6only=on; ## listen for ipv6
        
        server_name api.test;
        root        /path/to/yii-application/api/web/;
        index       index.php;
        
        access_log  /path/to/yii-application/log/api-access.log;
        error_log   /path/to/yii-application/log/api-error.log;
        
        location / {
            # Redirect everything that isn't a real file to index.php
            try_files $uri $uri/ /index.php$is_args$args;
        }
        
        # uncomment to avoid processing of calls to non-existing static files by Yii
        #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        #    try_files $uri =404;
        #}
        #error_page 404 /404.html;
        
        # deny accessing php files for the /assets directory
        location ~ ^/assets/.*\.php$ {
            deny all;
        }
        
        location ~ \.php$ {
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_pass 127.0.0.1:9000;
            #fastcgi_pass unix:/var/run/php5-fpm.sock;
            try_files $uri =404;
        }
        
        location ~* /\. {
            deny all;
        }
    }
    
    server {
        charset utf-8;
        client_max_body_size 128M;
        
        listen 80; ## listen for ipv4
        #listen [::]:80 default_server ipv6only=on; ## listen for ipv6
        
        server_name frontend.test;
        root        /path/to/yii-application/frontend/web/;
        index       index.php;
        
        access_log  /path/to/yii-application/log/frontend-access.log;
        error_log   /path/to/yii-application/log/frontend-error.log;
        
        location / {
            # Redirect everything that isn't a real file to index.php
            try_files $uri $uri/ /index.php$is_args$args;
        }
        
        # uncomment to avoid processing of calls to non-existing static files by Yii
        #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        #    try_files $uri =404;
        #}
        #error_page 404 /404.html;
        
        # deny accessing php files for the /assets directory
        location ~ ^/assets/.*\.php$ {
            deny all;
        }
        
        location ~ \.php$ {
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_pass 127.0.0.1:9000;
            #fastcgi_pass unix:/var/run/php5-fpm.sock;
            try_files $uri =404;
        }
        
        location ~* /\. {
            deny all;
        }
    }   
    
    server {
        charset utf-8;
        client_max_body_size 128M;
        
        listen 80; ## listen for ipv4
        #listen [::]:80 default_server ipv6only=on; ## listen for ipv6
        
        server_name backend.test;
        root        /path/to/yii-application/backend/web/;
        index       index.php;
        
        access_log  /path/to/yii-application/log/backend-access.log;
        error_log   /path/to/yii-application/log/backend-error.log;
        
        location / {
            # Redirect everything that isn't a real file to index.php
            try_files $uri $uri/ /index.php$is_args$args;
        }
        
        # uncomment to avoid processing of calls to non-existing static files by Yii
        #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        #    try_files $uri =404;
        #}
        #error_page 404 /404.html;
        
        # deny accessing php files for the /assets directory
        location ~ ^/assets/.*\.php$ {
            deny all;
        }
        
        location ~ \.php$ {
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_pass 127.0.0.1:9000;
            #fastcgi_pass unix:/var/run/php5-fpm.sock;
            try_files $uri =404;
        }
        
        location ~* /\. {
            deny all;
        }
    }
    
    server {
        charset utf-8;
        client_max_body_size 128M;
        
        listen 80; ## listen for ipv4
        #listen [::]:80 default_server ipv6only=on; ## listen for ipv6
        
        server_name rpc.test;
        root        /path/to/yii-application/rpc/web/;
        index       index.php;
        
        access_log  /path/to/yii-application/log/rpc-access.log;
        error_log   /path/to/yii-application/log/rpc-error.log;
        
        location / {
            # Redirect everything that isn't a real file to index.php
            try_files $uri $uri/ /index.php$is_args$args;
        }
        
        # uncomment to avoid processing of calls to non-existing static files by Yii
        #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        #    try_files $uri =404;
        #}
        #error_page 404 /404.html;
        
        # deny accessing php files for the /assets directory
        location ~ ^/assets/.*\.php$ {
            deny all;
        }
        
        location ~ \.php$ {
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_pass 127.0.0.1:9001;
            #fastcgi_pass unix:/var/run/php5-fpm.sock;
            try_files $uri =404;
        }
        
        location ~* /\. {
            deny all;
        }
    }
    ```

5. 更改主机文件以将域指向您的服务器。

    - Windows: `c:\Windows\System32\Drivers\etc\hosts`
    - Linux: `/etc/hosts`
    
    添加以下行：
    
    ```
    127.0.0.1   api.test
    127.0.0.1   frontend.test
    127.0.0.1   backend.test
    127.0.0.1   rpc.test
    ```

要登录应用程序，您需要先注册您的电子邮件地址，用户名和密码。
然后，您可以随时使用相同的电子邮件地址和密码登录应用程序。


> 注意：如果要在单个域上运行高级模板，则 `/` 是前端，而 `/admin` 是后端，请参阅[在共享主机上使用高级项目模板](topic-shared-hosting.md)。

## 使用Vagrant安装

这是最简单的安装方式，但是耗时较长（约20分钟）。

**这种安装方式不需要预先安装的软件（如Web服务器，PHP，MySQL等）** - 只是做下一步！

#### Linux/Unix 用户手册

1. 安装 [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
2. 安装 [Vagrant](https://www.vagrantup.com/downloads.html)
3. 创建 GitHub [personal API token](https://github.com/blog/1509-personal-api-tokens)
4. 准备项目:
   
    ```bash
    git clone https://github.com/shuijingwan/yii2-app-advanced.git
    cd yii2-app-advanced/vagrant/config
    cp vagrant-local.example.yml vagrant-local.yml
    ```
   
5. 将您的GitHub个人API令牌放置到 `vagrant-local.yml`
6. 将目录更改为项目根目录：

    ```bash
    cd yii2-app-advanced
    ```

7. 执行如下命令：

    ```bash
    vagrant plugin install vagrant-hostmanager
    vagrant up
    ```
   
等待完成后，在浏览器中访问如下URL即可

* api: http://y2aa-api.test
* frontend: http://y2aa-frontend.test
* backend: http://y2aa-backend.test
* rpc: http://y2aa-rpc.test
   
#### Windows 用户手册

1. 安装 [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
2. 安装 [Vagrant](https://www.vagrantup.com/downloads.html)
3. 重启电脑
4. 创建 GitHub [personal API token](https://github.com/blog/1509-personal-api-tokens)
5. 准备项目:
    * 下载 [yii2-app-advanced](https://github.com/yiisoft/yii2-app-advanced/archive/master.zip)
    * 解压
    * 进入 `yii2-app-advanced-master/vagrant/config` 文件夹
    * 重命名 `vagrant-local.example.yml` 为 `vagrant-local.yml`

6. 将您的GitHub个人API令牌放置到 `vagrant-local.yml`
7. 添加如下代码到 [hosts 文件](https://en.wikipedia.org/wiki/Hosts_(file)):
   
    ```
    192.168.83.137 y2aa-api.test
    192.168.83.137 y2aa-frontend.test
    192.168.83.137 y2aa-backend.test
    192.168.83.137 y2aa-rpc.test
    ```

8. 打开终端 (`cmd.exe`), **切换路径至项目根目录** 并且执行如下命令:

    ```bash
    vagrant plugin install vagrant-hostmanager
    vagrant up
    ```
   
   (猛击 [这里](http://www.wikihow.com/Change-Directories-in-Command-Prompt) 查看如何在命令提示符中更改目录) 

等待完成后，在浏览器中访问如下URL即可

* api: http://y2aa-api.test
* frontend: http://y2aa-frontend.test
* backend: http://y2aa-backend.test
* rpc: http://y2aa-rpc.test

