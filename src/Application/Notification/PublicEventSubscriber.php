<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Application\Notification;

use Loobee\Ddd\Domain\Event\EventInterface;
use Loobee\Ddd\Domain\Event\PublicEventInterface;
use Loobee\Ddd\Domain\Event\EventSubscriberInterface;

class PublicEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var NotificationRepositoryInterface
     */
    private $repository;

    /**
     * @param NotificationRepositoryInterface $repository
     */
    public function __construct(NotificationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param EventInterface $event
     *
     * @return bool
     */
    public function isSubscribedTo(EventInterface $event)
    {
        return $event instanceof PublicEventInterface;
    }

    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event)
    {
        $this->repository->save(new Notification($event));
    }
}