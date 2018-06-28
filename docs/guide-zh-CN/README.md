<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2高级项目模板</h1>
    <br>
</p>

Yii 2高级项目模板是一个最基本的 [Yii 2](http://www.yiiframework.com/) 应用程序，用于开发具有多层的复杂Web应用程序。

模板包括四个层：接口(实现 RESTful 风格的 Web Service 服务的 API)，前端，后端和控制台，每个都是单独的Yii应用程序。

该模板设计用于在团队开发环境中工作。 它支持在不同环境中部署应用程序。

它还有一些其他功能，并提供了必要的开箱即用的数据库操作，注册和重置密码等功能。

文档位于 [docs/guide-zh-CN/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-advanced)

## 目录
- [基本信息](README.md)
- [安装](start-installation.md)
    - [手动安装](start-installation.md)
    - [Vagrant 安装](start-installation.md#使用vagrant安装)
- [测试](start-testing.md)

应用目录结构
-------------------

```
common                   公共(所有应用程序共有的文件)
    config/              包含公共配置
    fixtures/            包含公共类的测试夹具
    logics/              包含在接口、前端、后端和控制台中使用的模型逻辑类
    mail/                包含电子邮件的视图文件
    messages/            包含国际化的消息文件
    models/              包含在接口、前端、后端和控制台中使用的模型数据类
    tests/               包含公共类的各种测试
    widgets/             包含公共的小部件
console                  控制台
    config/              包含控制台配置
    controllers/         包含控制台的控制器类(命令)
    migrations/          包含数据库迁移
    models/              包含控制台的模型类
    runtime/             包含运行时生成的文件，例如日志和缓存文件
backend                  后端
    assets/              包含应用程序的资源文件(javascript 和 css)
    config/              包含后端配置
    controllers/         包含后端的Web控制器类
    models/              包含后端的模型类
    runtime/             包含运行时生成的文件，例如日志和缓存文件
    tests/               包含后端应用程序的各种测试
    views/               包含Web应用程序的视图文件
    web/                 Web 应用根目录，包含 Web 入口文件
frontend                 前端
    assets/              包含应用程序的资源文件(javascript 和 css)
    config/              包含前端配置
    controllers/         包含前端的Web控制器类
    models/              包含前端的模型类
    runtime/             包含运行时生成的文件，例如日志和缓存文件
    tests/               包含前端应用程序的各种测试
    views/               包含Web应用程序的视图文件
    web/                 Web 应用根目录，包含 Web 入口文件
    widgets/             包含前端的小部件
api                      接口
    behaviors/           包含接口的行为类
    config/              包含接口配置
    controllers/         包含接口的Web控制器类
    fixtures/            包含接口的测试夹具
    models/              包含接口的模型类
    modules/             包含接口的模块
    rests/               包含接口的 REST API 类
    runtime/             包含运行时生成的文件，例如日志和缓存文件
    tests/               包含接口应用程序的各种测试
    views/               包含Web应用程序的视图文件
    web/                 Web 应用根目录，包含 Web 入口文件
vendor/                  包含相关的第三方软件包
environments/            包含基于环境的覆盖
.gitignore               包含由 git 版本系统忽略的目录列表。如果你需要的东西从来没有到你的源代码存储库，添加它。
composer.json            Composer 配置文件
init                     初始化脚本描述文件
init.bat                 Windows 下的初始化脚本描述文件
LICENSE.md               许可信息。 把你的项目许可证放到这里。特别是开源醒目。
README.md                安装模板的基本信息。请考虑将其替换为有关您的项目及其安装的信息。
requirements.php         安装使用 Yii 需求检查器。
yii                      控制台应用程序引导。
yii.bat                  Windows下的控制台应用程序引导。
```
