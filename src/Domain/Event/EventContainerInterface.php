<?php

namespace Loobee\Ddd\Domain\Event;

/**
 * Контейнер событий.
 */
interface EventContainerInterface
{
    /**
     * @return EventInterface[]
     */
    function getEvents();

    function eraseEvents();
}