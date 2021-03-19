<?php

namespace App\Http\Conversations;

use Validator;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class OnboardingConversation extends Conversation
{
    public function askLanguage()
    {
        $question = Question::create('Welcome to Marketplace Chatbot. Please select your language?')
            ->callbackId('select_service')
            ->addButtons([
                Button::create('English')->value('English'),
                Button::create('Swahili')->value('Swahili'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->bot->userStorage()->save([
                    'language' => $answer->getValue(),
                ]);

                $this->say('Continue!');
                $this->askName();
            }
        });
    }

    public function askName()
    {
        $this->ask('Please enter your name?', function (Answer $answer) {
            $this->bot->userStorage()->save([
                'name' => $answer->getText(),
            ]);

            $this->say('Nice to meet you '.$answer->getText());
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('Please enter your email?', function (Answer $answer) {
            $validator = Validator::make(['email' => $answer->getText()], [
                'email' => 'email',
            ]);

            if ($validator->fails()) {
                return $this->repeat('That doesn\'t look like a valid email. Please enter a valid email.');
            }

            $this->bot->userStorage()->save([
                'email' => $answer->getText(),
            ]);

            $this->askMobile();
        });
    }

    public function askMobile()
    {
        $this->ask('Great. Please enter your phone number?', function (Answer $answer) {
            // $validator = Validator::make(['mobile' => $answer->getText()], [
            //     'mobile' => 'mobile',
            // ]);

            // if ($validator->fails()) {
            //     return $this->repeat('That doesn\'t look like a valid Phone number with 10 characters. Please enter a valid phone number.');
            // }

            $this->bot->userStorage()->save([
                'mobile' => $answer->getText(),
            ]);

            $this->say('Great!');

            $this->bot->startConversation(new SelectServiceConversation());
        });
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askLanguage();
    }
}
