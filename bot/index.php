<?php

require('../vendor/autoload.php');

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
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
   // $bot->reply($bot->getMessage()->getText());

    $bot->reply(Question::create('Do you want to know development price?')->addButtons([
        Button::create('Sure')->value('sure'),
        Button::create('Not Now')->value('not know'),
    ]));
});

// Give the bot something to listen for.
$botman->hears('Not know', function (BotMan $bot) {
    $bot->reply('Thank you for being with us.');
    $bot->reply('Have a wonderful time.');
    $bot->reply(ButtonTemplate::create('Need further assistance? Talk to a representative')
	->addButton(ElementButton::create('Call Representative')
	    ->type('phone_number')
	    ->payload('+8801731123861')
	)
	->addButton(ElementButton::create('Visit Our Website')
	    ->url('http://binarybase.io/')
	)
);
});

$botman->hears('sure', function(BotMan $bot){
    $bot->reply(Question::create('Which price you want to know?')->addButtons([
        Button::create('App Development')->value('app'),
        Button::create('Web Design/Development')->value('web'),
    ]));
});

// Give the bot something to listen for.
$botman->hears('app', function (BotMan $bot) {
    $bot->reply(Question::create('What type of app are you building?')->addButtons([
        Button::create('Android')->value('android'),
        Button::create('Apple iOS')->value('ios'),
        Button::create('Apple iOS and Android')->value('both'),
    ]));
});

$botman->hears('android|ios|both', function (BotMan $bot) {
    $bot->reply(Question::create('Do people have to login?')->addButtons([
        Button::create('Email')->value('email'),
        Button::create('Social')->value('social'),
        Button::create('Mobile & OTP')->value('otp'),
        Button::create('No')->value('none'),
        Button::create('I don\'t know')->value('don\'t know about login'),
    ]));
});

$botman->hears('email|social|otp|don\'t know about login|none', function (BotMan $bot) {
    $bot->reply(Question::create('Do people create personal profiles?')->addButtons([
        Button::create('Yes')->value('yes'),
        Button::create('No')->value('no'),
        Button::create('I don\'t know')->value('don\'t know about profile'),
    ]));
});

$botman->hears('yes|no|don\'t know about profile', function (BotMan $bot) {
    $bot->reply(Question::create('How will you make money from your app?')->addButtons([
        Button::create('Upfront cost')->value('upfront'),
        Button::create('In-app purchase')->value('in-app'),
        Button::create('Free')->value('free'),
        Button::create('I don\'t know')->value('don\'t know about making money'),
    ]));
});

$botman->hears('upfront|in-app|don\'t know about making money|free', function (BotMan $bot) {
    $bot->reply(Question::create('Do people rate or review things?')->addButtons([
        Button::create('Yes')->value('yes, rating'),
        Button::create('No')->value('no, rating'),
        Button::create('I don\'t know')->value('don\'t know about rating'),
    ]));
});

$botman->hears('yes, rating|no, rating|don\'t know about rating', function (BotMan $bot) {
    $bot->reply(Question::create('Does your app need to get information from your website?')->addButtons([
        Button::create('Yes')->value('yes, get information'),
        Button::create('No')->value('no, not need'),
        Button::create('I don\'t know')->value('don\'t know about this'),
    ]));
});

$botman->hears('yes, get information|no, not need|don\'t know about this', function (BotMan $bot) {
    $bot->reply(Question::create('How nice should your app look?')->addButtons([
        Button::create('Bare-bones')->value('bare-bones'),
        Button::create('Stock')->value('stock'),
        Button::create('Beautiful')->value('beautiful'),
    ]));
});

$botman->hears('bare-bones|stock|beautiful', function (BotMan $bot) {
    $bot->reply(Question::create('Do you need an app icon?')->addButtons([
        Button::create('Yes')->value('yes, I need'),
        Button::create('No')->value('no, I have'),
        Button::create('I don\'t know')->value('don\'t know about icon'),
    ]));
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