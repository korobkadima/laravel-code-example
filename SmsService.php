<?php

namespace App\Services;

use SMSApi\Client;
use SMSApi\Api\SmsFactory;
use SMSApi\Exception\SmsapiException;

use App\Entities\User;

use Illuminate\Session\Store as Session;

use Log;

class SmsService
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var SmsFactory
     */
    protected $smsapi;

    /**
     * @var string $from
     */
    protected $from;

    /**
     * SmsService constructor.
     
     */
    public function __construct()
    {
        $this->client = new Client( config('services.smsapi.email') );
        $this->client->setPasswordHash(( config('services.smsapi.password') ));

        $this->smsapi = new SmsFactory;
        $this->smsapi->setClient($this->client);

        $this->from = config('services.smsapi.from');
     
    }

    /**
     * Send confirmed mail
     *
     * @param User $user
     * @return boolean
     */
    public function sendConfirmedSms(User $user)
    {
        $this->send($user->tel, 'Your code is ' . $user->sms_code);
    }

    /**
     * @param string $tel
     * @return string
     */
    protected function formatTelNumber($tel = '')
    {
        return preg_replace("/[^0-9]/", '', $tel);
    }

    public function send($tel = '', $text = '')
    {
        try {
            $actionSend = $this->smsapi->actionSend();

            $actionSend->setTo($tel);
            $actionSend->setText($text);
            $actionSend->setSender($this->from); //Pole nadawcy, lub typ wiadomości: 'ECO', '2Way'

            $response = $actionSend->execute();

            foreach ($response->getList() as $status)
            {
                logCreate('confirm sms send', [
                    'touch' => $tel,
                ]);
            }

            return true;

        } catch (SmsapiException $exception)
        {
            logCreate('sms sent failure', [
                'touch' => [
                    'data'  => $tel,
                    'error' => $exception,
                ],
            ]);

            return false;
        }
    }
}