<?php
$commonMessages = require __DIR__ . '/../../../common/messages/en-US/success.php';
$messages = [
    130001 => 'Get log list success',
    130002 => 'Get log details success',
    130003 => 'Get page list success',
    130004 => 'Get page details success',
    130005 => 'Create page success',
    130006 => 'Update page success',
    130007 => 'Delete page success',
    132001 => 'Get user list success',
    132002 => 'Get user details success',
    132003 => 'Create user success',
    132004 => 'Update user success',
    132005 => 'Delete user success',
];
return $commonMessages + $messages;
