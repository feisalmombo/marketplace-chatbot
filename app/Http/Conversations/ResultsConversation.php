<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class ResultsConversation extends Conversation
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
        $message .= 'Net Salary : '.$user->get('salary').'<br>';
        $message .= 'Interest rate : '."20%".'<br>';
        $message .= 'Facility Fee : '."7500".'<br>';
        $message .= 'Monthly Payment : '."88261".'<br>';
        $message .= 'Insurance Fee : '."1875".'<br>';
        $message .= 'Tenure : '.$user->get('period').'<br>';
        $message .= 'Debt Burden Ratio : '."12.61%".'<br>';
        $message .= 'Net Amount : '."490625".'<br>';
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
