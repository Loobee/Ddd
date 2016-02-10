<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

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