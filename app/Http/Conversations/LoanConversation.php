<?php

namespace App\Http\Conversations;

use Carbon\Carbon;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class LoanConversation extends Conversation
{
    public function askLoanPurpose()
    {
        $question = Question::create('Please enter your loan purpose?')
            ->callbackId('select_service')
            ->addButtons([
                Button::create('Salaried Loan')->value('Salaried Loan'),
                Button::create('Mortgage Loan')->value('Mortgage Loan'),
                Button::create('Personal Loan')->value('Personal Loan'),
                Button::create('Business Loan')->value('Business Loan'),
                Button::create('Overdraft Facility')->value('Overdraft Facility'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->bot->userStorage()->save([
                    'purpose' => $answer->getValue(),
                ]);

                $this->say('Continue!');
                $this->askLoanAmount();
            }
        });
    }

    public function askLoanAmount()
    {
        $this->ask('Please enter your loan amount?', function (Answer $answer) {
            $this->bot->userStorage()->save([
                'amount' => $answer->getText(),
            ]);

            $this->say('Thank you!');
            $this->askLoanPeriod();

        });
    }

    public function askLoanPeriod()
    {
        $this->ask('Please enter your loan period (in Month)?', function (Answer $answer) {
            $this->bot->userStorage()->save([
                'period' => $answer->getText(),
            ]);

            $this->say('Thank you!');
            $this->askNetSalary();
        });
    }

    public function askNetSalary()
    {
        $this->ask('Please enter your net salary?', function (Answer $answer) {
            $this->bot->userStorage()->save([
                'salary' => $answer->getText(),
            ]);

            $this->say('Thank you!');
            $this->askTermsConditions();

        });
    }

    public function askTermsConditions()
    {
        $question = Question::create('Please agree to our terms and conditions.?')
            ->callbackId('select_service')
            ->addButtons([
                Button::create('Yes')->value('Yes'),
                Button::create('No')->value('No'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->bot->userStorage()->save([
                    'conditions' => $answer->getValue(),
                ]);

                $this->say('Continue!');
                // $this->bot->startConversation(new ResultsConversation());
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
        $this->askLoanPurpose(); 
    }
}
