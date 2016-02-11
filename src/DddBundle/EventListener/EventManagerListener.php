<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\DddBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Console\ConsoleEvents;
use Loobee\Ddd\Domain\Event\EventManager;
use Loobee\Ddd\Domain\Event\EventSubscriberInterface as DomainEventSubscriberInterface;
use InvalidArgumentException;
use Doctrine\ORM\EntityManager;

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

        $this->subscribers    = $subscribers;
        $this->event_manager  = $event_manager;
    }


    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE   => 'onTerminate',
            ConsoleEvents::TERMINATE => 'onTerminate'
        ];
    }

    public function onTerminate()
    {
        $this->subscribe();
        $this->event_manager->publishEventContainers();
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