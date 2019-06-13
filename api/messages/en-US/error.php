<?php
$commonMessages = require __DIR__ . '/../../../common/messages/en-US/error.php';
$messages = [
    224002 => 'Log ID: {id}, does not exist',
    224003 => 'Data filter validation failed: {first_error}',
    224004 => 'User ID: {id}, status is disabled',
    224006 => 'Page ID: {id}, does not exist',
    224007 => 'Page ID: {id}, status is deleted',
    224008 => 'Page ID: {id}, status is disabled',
    224009 => 'Page ID: {id}, status is draft',
    226002 => 'User ID: {id}, does not exist',
    226003 => 'User ID: {id}, status is deleted',
    226004 => 'Data validation failed: {first_error}',
];
return $commonMessages + $messages;
