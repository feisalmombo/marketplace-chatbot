<?php

namespace App\Http\Conversations;

use Carbon\Carbon;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class DateTimeConversation extends Conversation
{
    // public function askDate()
    // {
    //     $availableDates = [
    //         Carbon::today()->addDays(1),
    //         Carbon::today()->addDays(2),
    //         Carbon::today()->addDays(3),
    //     ];

    //     $question = Question::create('Select the date')
    //         ->callbackId('select_date')
    //         ->addButtons([
    //             Button::create($availableDates[0]->format('M d'))->value($availableDates[0]->format('Y-m-d')),
    //             Button::create($availableDates[1]->format('M d'))->value($availableDates[1]->format('Y-m-d')),
    //             Button::create($availableDates[2]->format('M d'))->value($availableDates[2]->format('Y-m-d')),
    //         ]);

    //     $this->ask($question, function (Answer $answer) {
    //         if ($answer->isInteractiveMessageReply()) {
    //             $this->bot->userStorage()->save([
    //                 'date' => $answer->getValue(),
    //             ]);

    //             $this->askTime();
    //         }
    //     });
    // }

    // public function askTime()
    // {
    //     $question = Question::create('Select a time slot')
    //         ->callbackId('select_time')
    //         ->addButtons([
    //             Button::create('9 AM')->value('9 AM'),
    //             Button::create('1 PM')->value('1 PM'),
    //             Button::create('3 PM')->value('3 PM'),
    //         ]);

    //     $this->ask($question, function (Answer $answer) {
    //         if ($answer->isInteractiveMessageReply()) {
    //             $this->bot->userStorage()->save([
    //                 'timeSlot' => $answer->getValue(),
    //             ]);

    //             $this->bot->startConversation(new BookingConversation());
    //         }
    //     });
    // }

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
        $this->ask('Please enter your loan period?', function (Answer $answer) {
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
            // $this->say('Thank you '.$answer->getText());
            $this->bot->startConversation(new BookingConversation());

        });
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        // $this->askDate();
        $this->askLoanPurpose(); 
    }
}
