<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class SelectRegionConversation extends Conversation  
{
    public function askService()
    {
        $question = Question::create('Thank you. Please select your region?')
            ->callbackId('select_service')
            ->addButtons([
                Button::create('Tanga')->value('Tanga'),
                Button::create('Kilimanjaro')->value('Kilimanjaro'),
                Button::create('Kigoma')->value('Kigoma'),
                Button::create('Dar es Salaam')->value('Dar es Salaam'),
                Button::create('Iringa')->value('Iringa'),
                Button::create('Mwanza')->value('Mwanza'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->bot->userStorage()->save([
                    'region' => $answer->getValue(),
                ]);

                $this->bot->startConversation(new LoanConversation());
            }
        });
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askService();
    }
}
