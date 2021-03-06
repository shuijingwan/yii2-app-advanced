<?php
$commonMessages = require __DIR__ . '/../../../common/messages/zh-CN/error.php';
$messages = [
    230001 => '日志列表为空',
    230002 => '日志ID：{id}，不存在',
    230003 => '数据过滤器验证失败：{first_error}',
    230004 => '用户ID：{id}，的状态为已禁用',
    230005 => '页面列表为空',
    230006 => '页面ID：{id}，不存在',
    230007 => '页面ID：{id}，的状态为已删除',
    230008 => '页面ID：{id}，的状态为已禁用',
    230009 => '页面ID：{id}，的状态为草稿',
    232001 => '用户列表为空',
    232002 => '用户ID：{id}，不存在',
    232003 => '用户ID：{id}，的状态为已删除',
    232004 => '数据验证失败：{first_error}',
];
return $commonMessages + $messages;
