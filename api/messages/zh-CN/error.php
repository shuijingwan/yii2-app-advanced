<?php
$commonMessages = require __DIR__ . '/../../../common/messages/zh-CN/error.php';
$messages = [
    224002 => '日志ID：{id}，不存在',
    224003 => '数据过滤器验证失败：{first_error}',
    224004 => '用户ID：{id}，的状态为已禁用',
    224006 => '页面ID：{id}，不存在',
    224007 => '页面ID：{id}，的状态为已删除',
    224008 => '页面ID：{id}，的状态为已禁用',
    224009 => '页面ID：{id}，的状态为草稿',
    226002 => '用户ID：{id}，不存在',
    226003 => '用户ID：{id}，的状态为已删除',
    226004 => '数据验证失败：{first_error}',
];
return $commonMessages + $messages;
