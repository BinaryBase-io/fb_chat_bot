<?php

require('../vendor/autoload.php');

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

$config = [
    // Your driver-specific configuration
    'facebook' => [
        'token' => 'EAAe2nxlwuZC0BAJK1fxQReAExpR1jLuko6eb5rCSmKZAoaSvRCtDo40RjvVIpdREJZCgnOpSKOdU1ZCq0ALRYEgf8rctUkqlHaKLFZAcAjjNUammy1ppCQMqXKI51LZC5SOGHCHaaJoAo7EX3ZBqNC1M46ZACKNw14MjuubaERFp9K82qCeNurZBSE2dDJi5L0X4ZD',
        'app_secret' => 'cd9419dde4fd8ce37b4f0dde74c9cff1',
        'verification'=>'1319_ms_#2020',
    ]
];

// Load the driver(s) you want to use
DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);

// Create an instance
$botman = BotManFactory::create($config);

// Give the bot something to listen for.
$botman->hears('hello', function (BotMan $bot) {
    $bot->reply('Hello yourself.');
});

// Fallbacks
$botman->fallback(function($bot) {
    $bot->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...');
});

// Start listening
$botman->listen();