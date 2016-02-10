<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Infrastructure\Application\Notification;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Loobee\Ddd\Application\Notification\MessageProducerInterface;
use Loobee\Ddd\Application\Notification\Notification;

class RabbitMqMessageProducer implements MessageProducerInterface
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var AMQPChannel
     */
    private $channel = null;

    /**
     * @param AMQPStreamConnection $connection
     */
    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
    }

    public function open($exchange_name)
    {

    }

    public function close($exchange_name)
    {
        $this->channel->close();
        $this->connection->close();
    }

    /**
     * @param $exchange_name
     */
    private function connect($exchange_name)
    {
        if (null !== $this->channel)
        {
            return;
        }

        $this->channel = $this->connection->channel();
        $this->channel->exchange_declare($exchange_name, 'fanout', false, true, false);
        $this->channel->queue_declare($exchange_name, false, true, false, false);
        $this->channel->queue_bind($exchange_name, $exchange_name);
    }

    /**
     * @param $exchange_name
     *
     * @return AMQPChannel
     */
    protected function channel($exchange_name)
    {
        $this->connect($exchange_name);

        return $this->channel;
    }

    /**
     * @param string $exchange_name
     * @param Notification $notification
     */
    public function send($exchange_name, Notification $notification)
    {
        $this->channel($exchange_name)->basic_publish(
            new AMQPMessage(
                $notification->getEventBody(),
                [
                    'message_id' => $notification->getOccurredOn(),
                    'type'       => $notification->getEventType(),
                    'timestamp'  => $notification->getOccurredOn()->getTimestamp()
                ]
            ),
            $exchange_name
        );
    }
}