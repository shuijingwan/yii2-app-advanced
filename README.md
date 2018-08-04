<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for developing complex Web applications with multiple tiers.

The template includes four tiers: api, front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide-zh-CN/README.md](docs/guide-zh-CN/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-advanced)

## TABLE OF CONTENTS
- [Basic info](docs/guide-zh-CN/README.md)
- [Installation](docs/guide-zh-CN/start-installation.md)
    - [Manual installation](docs/guide-zh-CN/start-installation.md)
    - [Vagrant installation](docs/guide-zh-CN/start-installation.md#使用vagrant安装)
- [Testing](docs/guide-zh-CN/start-testing.md)

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    fixtures/            contains fixtures for common classes
    logics/              contains logic classes used in both backend and frontend and api and console
    mail/                contains view files for e-mails
    messages/            contains message files for I18N
    models/              contains model classes used in both backend and frontend and api and console
    services             contains service classes used in both backend and frontend and api and console
    tests/               contains various tests for common classes
    widgets/             contains common widgets
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
    services/            contains console-specific service classes
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    services/            contains backend-specific service classes
    tests/               contains various tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    services/            contains frontend-specific service classes
    tests/               contains various tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
api
    behaviors/           contains behaviors for api application
    config/              contains api configurations
    controllers/         contains Web controller classes
    fixtures/            contains fixtures for api application
    messages/            contains message files for I18N
    models/              contains api-specific model classes
    modules/             contains modules for api application
    rests/               contains rests for api application
    runtime/             contains files generated during runtime
    services/            contains api-specific service classes
    tests/               contains various tests for api application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
rpc
    assets/              contains application assets such as JavaScript and CSS
    config/              contains rpc configurations
    controllers/         contains Web controller classes
    messages/            contains message files for I18N
    models/              contains rpc-specific model classes
    modules/             contains modules for rpc application
    runtime/             contains files generated during runtime
    services/            contains rpc-specific service classes
    tests/               contains various tests for rpc application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
.gitignore               contains a list of directories ignored by git version system. If you need something never get to your source code repository, add it there.
composer.json            Composer config described in Configuring Composer.
init                     initialization script described in Configuration and environments.
init.bat                 same for Windows.
LICENSE.md               license info. Put your project license there. Especially when opensourcing.
README.md                basic info about installing template. Consider replacing it with information about your project and its installation.
requirements.php         Yii requirements checker.
yii                      console application bootstrap.
yii.bat                  same for Windows.
```
