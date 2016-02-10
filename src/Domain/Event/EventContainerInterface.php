<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

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