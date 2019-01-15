<?php
$commonMessages = require __DIR__ . '/../../../common/messages/zh-CN/success.php';
$messages = [
    130001 => '获取日志列表成功',
    130002 => '获取日志详情成功',
    130003 => '获取页面列表成功',
    130004 => '获取页面详情成功',
    130005 => '创建页面成功',
    130006 => '更新页面成功',
    130007 => '删除页面成功',
    132001 => '获取用户列表成功',
    132002 => '获取用户详情成功',
    132003 => '创建用户成功',
    132004 => '更新用户成功',
    132005 => '删除用户成功',
];
return $commonMessages + $messages;
