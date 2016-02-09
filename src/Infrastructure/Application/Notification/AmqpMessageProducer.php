<?php

namespace Loobee\Ddd\Infrastructure\Application\Notification;

use AMQPExchange;
use Loobee\Ddd\Application\Notification\Notification;
use Loobee\Ddd\Application\Notification\MessageProducerInterface;

class AmqpMessageProducer implements MessageProducerInterface
{
    /**
     * @var AMQPExchange
     */
    protected $exchange;

    public function __construct(AMQPExchange $exchange)
    {
        $this->exchange = $exchange;
    }

    public function open($exchangeName) { }

    public function close($exchangeName) { }

    public function send($exchange_name, Notification $notification)
    {
        $this->exchange->publish(
            $notification->getEventBody(),
            null,
            AMQP_NOPARAM,
            [
                'message_id' => $notification->getOccurredOn(),
                'type'       => $notification->getEventType(),
                'timestamp'  => $notification->getOccurredOn()->getTimestamp()
            ]
        );
    }
}