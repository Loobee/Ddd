<?php

namespace Loobee\Ddd\Infrastructure\Persistence\Application\Notification;

use Loobee\Ddd\Infrastructure\Persistence\Domain\DoctrineEntityRepository;
use Loobee\Ddd\Application\Notification\Notification;
use Loobee\Ddd\Application\Notification\PublishedMessage;
use Loobee\Ddd\Application\Notification\PublishedMessageRepositoryInterface;

class DoctrinePublishedMessageRepository extends DoctrineEntityRepository implements PublishedMessageRepositoryInterface
{
    protected function getEntity()
    {
        return PublishedMessage::class;
    }

    public function getMostRecentPublishedMessageId($type_name)
    {
        $message = $this->getEntityRepository()->findOneByTypeName($type_name);

        if (!empty($message))
        {
            /** @var PublishedMessage $message */
            return $message->getMostRecentPublishedMessageId();
        }

        return null;
    }

    public function trackMostRecentPublishedMessage($type_name, Notification $notification)
    {
        $id = $notification->getId();

        $published_message = $this->getEntityRepository()->findOneByTypeName($type_name);

        if (empty($published_message))
        {
            $published_message = new PublishedMessage($type_name, $id);
        }

        $published_message->setMostRecentPublishedMessageId($id);

        $this->save($published_message);
    }
}