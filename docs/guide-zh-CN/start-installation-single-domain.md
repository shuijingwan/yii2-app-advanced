安装(单域名)
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

1. 编辑 \frontend\config\main.php

    ```
    return [
        'components' => [
            'request' => [
                'baseUrl' => '',
                'csrfParam' => '_csrf-frontend',
            ],
            'urlManager' => [
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'rules' => [
                ],
            ],
        ],
    ];
    ```

2. 编辑 \backend\config\main.php

    ```
    return [
        'homeUrl' => '/backend',
        'components' => [
            'request' => [
                'baseUrl' => '/backend',
                'csrfParam' => '_csrf-backend',
                'csrfCookie' => [
                    'httpOnly' => true,
                    'path' => '/backend',
                ],
            ],
            'user' => [
                'identityClass' => 'backend\models\User',
                'enableAutoLogin' => true,
                'identityCookie' => [
                    'name' => '_identity-backend',
                    'path' => '/backend',
                    'httpOnly' => true
                ],
            ],
            'session' => [
                // this is the name of the session cookie used for login on the backend
                'name' => 'advanced-backend',
                'cookieParams' => [
                    'path' => '/backend',
                ],
            ],
            'urlManager' => [
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'rules' => [
                ],
            ],
        ],
    ];
    ```
   
3. 编辑 \api\config\main.php

    ```
    return [
        'homeUrl' => '/api',
        'components' => [
            'request' => [
                'baseUrl' => '/api',
                'csrfParam' => '_csrf-api',
                'parsers' => [
                    'application/json' => 'yii\web\JsonParser',
                ]
            ],
            'urlManager' => require __DIR__ . '/urlManager.php',
        ],
    ];
    ```
   
4. 编辑 \rpc\config\main.php

    ```
    return [
        'homeUrl' => '/rpc',
        'components' => [
            'request' => [
                'baseUrl' => '/rpc',
                'csrfParam' => '_csrf-api',
            ],
            'urlManager' => [
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'rules' => [
                ],
            ],
        ],
    ];
    ```
   
5. 编辑 \environments\dev\frontend\web\robots.txt、\environments\prod\frontend\web\robots.txt

    ```
    User-agent: *
    Disallow: /frontend/web
    Disallow: /backend/web
    Disallow: /api/web
    Disallow: /rpc/web
    ```

6. 打开控制台终端，执行 `init` 命令并选择 `dev` 作为环境。

    ```
    /path/to/php-bin/php /path/to/yii-application/init
    ```
    
    如果使用脚本自动化，可以在非交互模式下执行 `init` 。
    
    ```
    /path/to/php-bin/php /path/to/yii-application/init --env=Production --overwrite=All
    ```

7. 创建一个新的数据库，并相应地调整 `common/config/main-local.php` 中的 `components['db']` 配置。

8. 打开控制台终端，执行迁移命令 
    ```
    /path/to/php-bin/php /path/to/yii-application/yii migrate --migrationPath=@yii/log/migrations/
    /path/to/php-bin/php /path/to/yii-application/yii migrate
    ```

9. 设置Web服务器的文档根目录：

    - 对于接口 `/path/to/yii-application/api/web/` 并且使用URL `http://y2aa.test/api/`
    - 对于前端 `/path/to/yii-application/frontend/web/` 并且使用URL `http://y2aa.test/`
    - 对于后端 `/path/to/yii-application/backend/web/` 并且使用URL `http://y2aa.test/backend/`
    - 对于远程过程调用 `/path/to/yii-application/rpc/web/` 并且使用URL `http://y2aa.test/rpc/`
    
    对于Apache，使用如下配置：
    
    ```
    <VirtualHost *:80>
        ServerName y2aa.test
    
        #ErrorLog /path/to/yii-application/log/y2aa.test.error.log
        #CustomLog /path/to/yii-application/log/y2aa.test.access.log combined
        AddDefaultCharset UTF-8
    
        Options FollowSymLinks
        DirectoryIndex index.php index.html
        RewriteEngine on
    
        RewriteRule /\. - [L,F]
    
        DocumentRoot /path/to/yii-application/frontend/web
        <Directory /path/to/yii-application/frontend/web>
            AllowOverride none
            <IfVersion < 2.4>
                Order Allow,Deny
                Allow from all
            </IfVersion>
            <IfVersion >= 2.4>
                Require all granted
            </IfVersion>
    
            # if a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # otherwise forward the request to index.php
            RewriteRule ^ index.php [L]
        </Directory>
    
        # redirect to the URL without a trailing slash (uncomment if necessary)
        #RewriteRule ^/backend/$ /backend [L,R=301]
    
        Alias /backend /path/to/yii-application/backend/web
        # prevent the directory redirect to the URL with a trailing slash
        RewriteRule ^/backend$ /backend/ [L,PT]
        <Directory /path/to/yii-application/backend/web>
            AllowOverride none
            <IfVersion < 2.4>
                Order Allow,Deny
                Allow from all
            </IfVersion>
            <IfVersion >= 2.4>
                Require all granted
            </IfVersion>
    
            # if a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # otherwise forward the request to index.php
            RewriteRule ^ index.php [L]
        </Directory>
        
        # redirect to the URL without a trailing slash (uncomment if necessary)
        #RewriteRule ^/api/$ /api [L,R=301]
    
        Alias /api /path/to/yii-application/api/web
        # prevent the directory redirect to the URL with a trailing slash
        RewriteRule ^/api$ /api/ [L,PT]
        <Directory /path/to/yii-application/api/web>
            AllowOverride none
            <IfVersion < 2.4>
                Order Allow,Deny
                Allow from all
            </IfVersion>
            <IfVersion >= 2.4>
                Require all granted
            </IfVersion>
    
            # if a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # otherwise forward the request to index.php
            RewriteRule ^ index.php [L]
        </Directory>
        
        # redirect to the URL without a trailing slash (uncomment if necessary)
        #RewriteRule ^/rpc/$ /rpc [L,R=301]
    
        Alias /rpc /path/to/yii-application/rpc/web
        # prevent the directory redirect to the URL with a trailing slash
        RewriteRule ^/rpc$ /rpc/ [L,PT]
        <Directory /path/to/yii-application/rpc/web>
            AllowOverride none
            <IfVersion < 2.4>
                Order Allow,Deny
                Allow from all
            </IfVersion>
            <IfVersion >= 2.4>
                Require all granted
            </IfVersion>
    
            # if a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # otherwise forward the request to index.php
            RewriteRule ^ index.php [L]
        </Directory>
    </VirtualHost>
    ```
    
    Nginx使用如下配置：
    
    ```
    server {
        listen 80;
        server_name y2aa.test;
    
        root /path/to/yii-application;
    
        #error_log /path/to/yii-application/log/y2aa.test.error.log warn;
        #access_log /path/to/yii-application/log/y2aa.test.access.log main;
        charset UTF-8;
        index index.php index.html;
    
        location / {
            root /path/to/yii-application/frontend/web;
            try_files $uri $uri/ /frontend/web/index.php$is_args$args;
    
            # omit static files logging, and if they don't exist, avoid processing by Yii (uncomment if necessary)
            #location ~ ^/.+\.(css|js|ico|png|jpe?g|gif|svg|ttf|mp4|mov|swf|pdf|zip|rar)$ {
            #    log_not_found off;
            #    access_log off;
            #    try_files $uri =404;
            #}
    
            location ~ ^/assets/.+\.php(/|$) {
                deny all;
            }
        }
    
        location /backend {
            alias /path/to/yii-application/backend/web/;
    
            # redirect to the URL without a trailing slash (uncomment if necessary)
            #location = /backend/ {
            #    return 301 /backend;
            #}
    
            # prevent the directory redirect to the URL with a trailing slash
            location = /backend {
                # if your location is "/backend", try use "/backend/backend/web/index.php$is_args$args"
                # bug ticket: https://trac.nginx.org/nginx/ticket/97
                try_files $uri /backend/backend/web/index.php$is_args$args;
            }
    
            # if your location is "/backend", try use "/backend/backend/web/index.php$is_args$args"
            # bug ticket: https://trac.nginx.org/nginx/ticket/97
            try_files $uri $uri/ /backend/backend/web/index.php$is_args$args;
    
            # omit static files logging, and if they don't exist, avoid processing by Yii (uncomment if necessary)
            #location ~ ^/backend/.+\.(css|js|ico|png|jpe?g|gif|svg|ttf|mp4|mov|swf|pdf|zip|rar)$ {
            #    log_not_found off;
            #    access_log off;
            #    try_files $uri =404;
            #}
    
            location ~ ^/backend/assets/.+\.php(/|$) {
                deny all;
            }
        }
        
        location /api {
            alias /path/to/yii-application/api/web/;
    
            # redirect to the URL without a trailing slash (uncomment if necessary)
            #location = /api/ {
            #    return 301 /api;
            #}
    
            # prevent the directory redirect to the URL with a trailing slash
            location = /api {
                # if your location is "/api", try use "/api/api/web/index.php$is_args$args"
                # bug ticket: https://trac.nginx.org/nginx/ticket/97
                try_files $uri /api/api/web/index.php$is_args$args;
            }
    
            # if your location is "/api", try use "/api/api/web/index.php$is_args$args"
            # bug ticket: https://trac.nginx.org/nginx/ticket/97
            try_files $uri $uri/ /api/api/web/index.php$is_args$args;
    
            # omit static files logging, and if they don't exist, avoid processing by Yii (uncomment if necessary)
            #location ~ ^/api/.+\.(css|js|ico|png|jpe?g|gif|svg|ttf|mp4|mov|swf|pdf|zip|rar)$ {
            #    log_not_found off;
            #    access_log off;
            #    try_files $uri =404;
            #}
    
            location ~ ^/api/assets/.+\.php(/|$) {
                deny all;
            }
        }
        
        location /rpc {
            alias /path/to/yii-application/rpc/web/;
    
            # redirect to the URL without a trailing slash (uncomment if necessary)
            #location = /rpc/ {
            #    return 301 /rpc;
            #}
    
            # prevent the directory redirect to the URL with a trailing slash
            location = /rpc {
                # if your location is "/rpc", try use "/rpc/rpc/web/index.php$is_args$args"
                # bug ticket: https://trac.nginx.org/nginx/ticket/97
                try_files $uri /rpc/rpc/web/index.php$is_args$args;
            }
    
            # if your location is "/rpc", try use "/rpc/rpc/web/index.php$is_args$args"
            # bug ticket: https://trac.nginx.org/nginx/ticket/97
            try_files $uri $uri/ /rpc/rpc/web/index.php$is_args$args;
    
            # omit static files logging, and if they don't exist, avoid processing by Yii (uncomment if necessary)
            #location ~ ^/rpc/.+\.(css|js|ico|png|jpe?g|gif|svg|ttf|mp4|mov|swf|pdf|zip|rar)$ {
            #    log_not_found off;
            #    access_log off;
            #    try_files $uri =404;
            #}
    
            location ~ ^/rpc/assets/.+\.php(/|$) {
                deny all;
            }
        }
    
        location ~ ^/.+\.php(/|$) {
            rewrite (?!^/((frontend|backend|api|rpc)/web|backend|api|rpc))^ /frontend/web$uri break;
            rewrite (?!^/backend/web)^/backend(/.+)$ /backend/web$1 break;
            rewrite (?!^/api/web)^/api(/.+)$ /api/web$1 break;
            rewrite (?!^/rpc/web)^/rpc(/.+)$ /rpc/web$1 break;
    
            fastcgi_pass 127.0.0.1:9000; # proxy requests to a TCP socket
            #fastcgi_pass unix:/var/run/php-fpm.sock; # proxy requests to a UNIX domain socket (check your www.conf file)
            fastcgi_split_path_info ^(.+\.php)(.*)$;
            include /etc/nginx/fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            try_files $fastcgi_script_name =404;
        }
    
        location ~ /\. {
            deny all;
        }
    }
    ```

10. 更改主机文件以将域指向您的服务器。

    - Windows: `c:\Windows\System32\Drivers\etc\hosts`
    - Linux: `/etc/hosts`
    
    添加以下行：
    
    ```
    127.0.0.1   y2aa.test
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

