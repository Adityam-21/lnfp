<?php

use App\Events\UserRegistered;
use App\Listeners\SendWelcomeEmail;

protected $listen = [
    UserRegistered::class => [
        SendWelcomeEmail::class,
    ],
];
