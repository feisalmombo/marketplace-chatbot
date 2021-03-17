<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use App\Http\Conversations\OnboardingConversation;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        // $botman->hears('{message}', function($botman, $message) {

        //     if ($message == 'compare') {
        //         $this->startConversation($botman);
        //     }else{
        //         $botman->reply("write 'compare' to start...");
        //     }

        // });

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php.
     *
     * @param BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new OnboardingConversation());
    }
}
