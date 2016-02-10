<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Application\Notification;

interface MessageProducerInterface
{
    public function open($exchange_name);
    public function close($exchange_name);

    /**
     * @param string $exchange_name
     * @param Notification $notification
     */
    public function send($exchange_name, Notification $notification);
}