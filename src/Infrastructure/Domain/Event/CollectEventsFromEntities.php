<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Infrastructure\Domain\Event;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Loobee\Ddd\Domain\Event\EventManager;
use Loobee\Ddd\Domain\Event\EventContainerInterface;

class CollectEventsFromEntities implements EventSubscriber
{
    /**
     * @var EventManager
     */
    private $event_manager;

    /**
     * @param EventManager $event_manager
     */
    public function __construct(EventManager $event_manager)
    {
        $this->event_manager = $event_manager;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove
        ];
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        $this->collectEventsFromEntity($event);
    }

    public function postUpdate(LifecycleEventArgs $event)
    {
        $this->collectEventsFromEntity($event);
    }

    public function postRemove(LifecycleEventArgs $event)
    {
        $this->collectEventsFromEntity($event);
    }

    private function collectEventsFromEntity(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if ($entity instanceof EventContainerInterface)
        {
            $this->event_manager->registerEventContainer($entity);
        }
    }
}