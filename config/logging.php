<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => 'debug',
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

        'post_get_list' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/post/post_get_list.log'),
            'days' => env('SYNC_POST_LOG_FILES_KEEPING'),
        ],
        'post_create' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/post/post_create.log'),
            'days' => env('SYNC_POST_LOG_FILES_KEEPING'),
        ],
        'post_update' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/post/post_update.log'),
            'days' => env('SYNC_POST_LOG_FILES_KEEPING'),
        ],
        'post_delete' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/post/post_delete.log'),
            'days' => env('SYNC_POST_LOG_FILES_KEEPING'),
        ],
        'user_register' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/user/user_register.log'),
            'days' => env('SYNC_POST_LOG_FILES_KEEPING'),
        ],
        'user_login' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/user/user_login.log'),
            'days' => env('SYNC_POST_LOG_FILES_KEEPING'),
        ],
        'user_logout' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/user/user_logout.log'),
            'days' => env('SYNC_POST_LOG_FILES_KEEPING'),
        ],
    ],

];
