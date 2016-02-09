<?php

namespace Loobee\Ddd\Infrastructure\Application\Notification;

use AMQPQueue;
use React\EventLoop\LoopInterface;
use React\EventLoop\Timer\TimerInterface;
use BadMethodCallException;
use Loobee\Ddd\Application\Notification\Notification;

abstract class AmqpExchangeListener
{
    /**
     * @var AMQPQueue
     */
    protected $queue;

    /**
     * @var LoopInterface
     */
    protected $loop;

    /**
     * @var bool
     */
    protected $closed = false;

    /**
     * @var TimerInterface
     */
    private $timer;

    /**
     * @var bool
     */
    private $stop;

    public function __construct(AMQPQueue $queue, LoopInterface $loop)
    {
        $this->queue = $queue;
        $this->loop  = $loop;
        $this->timer = $this->loop->addPeriodicTimer(1, [$this, 'listen']);
    }

    public function close()
    {
        if ($this->closed)
        {
            return;
        }

        $this->loop->cancelTimer($this->timer);

        unset($this->queue);

        $this->closed = true;
    }

    public function listen()
    {
        if ($this->closed)
        {
            throw new BadMethodCallException('This listener object is closed and cannot receive any more messages.');
        }

        while ($envelope = $this->queue->get())
        {
            $domain_event = Notification::getEventFromBody($envelope->getType(), $envelope->getBody());

            if ($this->listensTo($envelope->getType()))
            {
                $this->handle($domain_event);
            }

            if ($this->stop)
            {
                return;
            }
        }
    }

    public function stop()
    {
        $this->stop = true;
    }

    /**
     * @param string $event_type
     *
     * @return bool
     */
    abstract protected function listensTo($event_type);

    /**
     * @param $event
     */
    abstract protected function handle($event);
}