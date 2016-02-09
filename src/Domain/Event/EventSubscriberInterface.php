<?php

namespace Loobee\Ddd\Domain\Event;

/**
 * Интерфейс подписчика.
 */
interface EventSubscriberInterface
{
    /**
     * @param EventInterface $event
     *
     * @return bool
     */
    public function isSubscribedTo(EventInterface $event);

    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event);
}