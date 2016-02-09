<?php

namespace Loobee\Ddd\Infrastructure\Persistence\Application\Notification;

use Loobee\Ddd\Infrastructure\Persistence\Domain\DoctrineEntityRepository;
use Loobee\Ddd\Application\Notification\Notification;
use Loobee\Ddd\Application\Notification\NotificationRepositoryInterface;

class DoctrineNotificationRepository extends DoctrineEntityRepository implements NotificationRepositoryInterface
{
    protected function getEntity()
    {
        return Notification::class;
    }

    public function allNotificationSince($id = 0)
    {
        $query = $this->getEntityRepository()->createQueryBuilder('e');

        if (!empty($id))
        {
            $query->where('e.id > :id');
            $query->setParameters(['id' => $id]);
        }

        $query->orderBy('e.id');

        return $query->getQuery()->getResult();
    }
}