<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class BookingConversation extends Conversation
{
    public function confirmBooking()
    {
        $user = $this->bot->userStorage()->find();

        $message = '------------------------------------------------ <br>';
        $message .= 'Name : '.$user->get('name').'<br>';
        $message .= 'Email : '.$user->get('email').'<br>';
        $message .= 'Mobile : '.$user->get('mobile').'<br>';
        $message .= 'Region : '.$user->get('region').'<br>';
        $message .= 'Loan purpose : '.$user->get('purpose').'<br>';
        $message .= 'Loan amount : '.$user->get('amount').'<br>';
        $message .= 'Loan period : '.$user->get('period').'<br>';
        $message .= 'Net Salary : '.$user->get('salary').'<br>';
        $message .= '------------------------------------------------';

        $this->say('Great. Here is your final details. <br><br>'.$message);
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->confirmBooking();
    }
}
