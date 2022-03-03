<?php


namespace App\Services\Sms;


interface SmsSender
{
    /**
     * @param $number
     * @param $text
     * @return void
     */
    public function send($number, $text): void;
}
