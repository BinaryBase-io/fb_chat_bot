<?php

require('../vendor/autoload.php');

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

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
$botman->hears('hello|hi', function (BotMan $bot) {
    $bot->reply('We are glad to see you.');
    $bot->reply($bot->getMessage()->getPayload());

    $bot->reply(Question::create('Do you want to know development price?')->addButtons([
        Button::create('Yes')->value('yes'),
        Button::create('No')->value('no'),
    ]));
});

// Give the bot something to listen for.
$botman->hears('No', function (BotMan $bot) {
    $bot->reply('Thank you for being with us.');
    $bot->reply('Have a wonderful time.');
});

$botman->hears('yes', function(BotMan $bot){
    $bot->reply(Question::create('Which\'s price you want to know?')->addButtons([
        Button::create('App Development')->value('app'),
        Button::create('Web Design/Development')->value('web'),
    ]));
});

// Give the bot something to listen for.
$botman->hears('app', function (BotMan $bot) {

});

// Give the bot something to listen for.
$botman->hears('web', function (BotMan $bot) {
    $bot->reply('Developer don\'t have that much time to implement this one.' ) ;
    $bot->reply('Please check app price for now.') ;
});

// Fallbacks
$botman->fallback(function($bot) {
    $bot->reply('Sorry, I did not understand these commands. Here is a list of commands I understand:');
    $bot->reply('hi | app | web');
});

// Start listening
$botman->listen();