<?php
namespace App\Services\Local;

use App\Services\MailServiceInterface;

class MailService extends \App\Services\Production\MailService implements MailServiceInterface
{
    public function __construct()
    {
    }

    public function sendMail($title, $from, $to, $template, $data)
    {
        if (config('app.offline_mode')) {
            return true;
        }

        if (\App::environment() != 'production') {
            $title = '['.\App::environment().'] '.$title;
            $to    = [
                'address' => config('mail.tester'),
                'name'    => \App::environment().' Original: '.$to['address'],
            ];
        }

        \Mail::send(
            $template,
            $data,
            function ($message) use ($title, $to, $from) {
                /* @var \Illuminate\Mail\Message $message */
                $message->subject($title);
                $message->from($from['address'], $from['name']);
                $message->to($to['address'], $to['name']);
            }
        );

        return true;
    }

    public function sendInquiryMailToSekaihe($inquiry)
    {
        return true;
    }
}
