<?php

namespace Loobee\Ddd\DddBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Console\ConsoleEvents;
use Loobee\Ddd\Domain\Event\EventManager;
use Loobee\Ddd\Domain\Event\EventSubscriberInterface as DomainEventSubscriberInterface;
use InvalidArgumentException;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

class EventManagerListener implements EventSubscriberInterface
{
    /**
     * @var array
     */
    private $subscribers;

    /**
     * @var EventManager
     */
    private $event_manager;

    /**
     * @param array $subscribers
     * @param EventManager $event_manager
     */
    public function __construct(array $subscribers = [], EventManager $event_manager)
    {
        foreach($subscribers as $subscriber)
        {
            if (!$subscriber instanceof DomainEventSubscriberInterface)
            {
                throw new InvalidArgumentException(
                    sprintf('The %s not implement DomainEventSubscriberInterface'), get_class($subscriber)
                );
            }
        }

        $this->subscribers = $subscribers;
        $this->event_manager = $event_manager;
    }


    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST    => 'onRequest',
            ConsoleEvents::COMMAND   => 'onCommand',
            KernelEvents::RESPONSE   => 'onTerminate', // TODO: ::TERMINATE In prod mode
            ConsoleEvents::TERMINATE => 'onTerminate'
        ];
    }

    public function onTerminate()
    {
        $this->event_manager->publishEventContainers();
    }

    public function onRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest())
        {
            return;
        }

        $this->subscribe();
    }

    public function onCommand(ConsoleCommandEvent $event)
    {
        $this->subscribe();
    }

    private function subscribe()
    {
        foreach($this->subscribers as $subscriber)
        {
            $this->event_manager->subscribe($subscriber);
        }

        $this->subscribers = [];
    }


}