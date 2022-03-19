<?php

namespace App\Listeners;

use App\Events\CourierAppointed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use SMSCenter\SMSCenter;

class SendCourierContacts
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\CourierAppointed $event
     * @return void
     */
    public function handle(CourierAppointed $event)
    {
        $smsc = new SMSCenter(config('services.smsc.login'), config('services.smsc.password'), false, [
            'charset' => SMSCenter::CHARSET_UTF8,
            'fmt' => SMSCenter::FMT_JSON
        ]);

        // Отправка сообщения
        $message ="Вам назначен курьер {$event->order->courier->name} тел. +{$event->order->courier->phone}";

        Log::info($smsc->send('+'.$event->order->client->phone, $message, config('services.smsc.sender')));
    }
}
