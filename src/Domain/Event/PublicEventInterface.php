<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Event;

/**
 * Служит тегом, указывающим что событие является публичным.
 *
 * Публичные события подхватывает система нотификаций, которая оповещает внешние сервисы.
 */
interface PublicEventInterface
{
}