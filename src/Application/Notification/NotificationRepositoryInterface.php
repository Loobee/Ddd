<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Application\Notification;

use Loobee\Ddd\Domain\EntityRepositoryInterface;

interface NotificationRepositoryInterface extends EntityRepositoryInterface
{
    /**
     * Получить нотификации начиная с ID (не включая).
     *
     * @note При $id = 0 будут возвращены все нотификации.
     *
     * @param integer $id ID
     *
     * @return Notification[]
     */
    public function allNotificationSince($id = 0);
}
