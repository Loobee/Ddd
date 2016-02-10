<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Event;

/**
 * Стандартная реализация EventContainerInterface.
 */
trait EventContainerDefaultImplementationTrait
{
    /**
     * @var EventInterface[]
     */
    private $events = [];

    /**
     * Создать событие.
     *
     * @param EventInterface $event
     */
    final protected function createEvent(EventInterface $event)
    {
        $this->events[] = $event;
    }

    /**
     * @return EventInterface[]
     */
    final public function getEvents()
    {
        return $this->events;
    }

    final public function eraseEvents()
    {
        $this->events = [];
    }
}