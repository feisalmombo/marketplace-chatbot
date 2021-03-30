<?php

use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('.*(compare|Compare).*', BotManController::class.'@startConversation');
