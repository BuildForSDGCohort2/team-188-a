<?php

namespace App;
use Twilio\Rest\Client;

class Sms
{
    public function send($recipients, $message)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        // $recipients = '+254731090832';

        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients, array('from' => $twilio_number, 'body' => $message));
    }

}
