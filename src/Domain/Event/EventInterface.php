<?php

namespace Loobee\Ddd\Domain\Event;

use DateTime;

/**
 * Интерфейс для событий домена.
 */
interface EventInterface
{
    /**
     * @return DateTime
     */
    public function getOccurredOn();
}