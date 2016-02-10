<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Application\Notification;

class NotificationService
{
    /**
     * @var NotificationRepositoryInterface
     */
    private $notification_repository;

    /**
     * @var PublishedMessageRepositoryInterface
     */
    private $published_message_repository;

    /**
     * @var MessageProducerInterface
     */
    private $message_producer;

    /**
     * @param NotificationRepositoryInterface $notification_repository
     * @param PublishedMessageRepositoryInterface $published_message_repository
     * @param MessageProducerInterface $message_producer
     */
    public function __construct(
        NotificationRepositoryInterface $notification_repository,
        PublishedMessageRepositoryInterface $published_message_repository,
        MessageProducerInterface $message_producer)
    {
        $this->notification_repository = $notification_repository;
        $this->published_message_repository = $published_message_repository;
        $this->message_producer = $message_producer;
    }

    /**
     * @param string $exchange_name
     *
     * @return integer Количество опубликованых нотификаций
     */
    public function publishNotifications($exchange_name)
    {
        $last_message_id = $this->published_message_repository->getMostRecentPublishedMessageId($exchange_name);
        $notifications   = $this->notification_repository->allNotificationSince($last_message_id);

        if (empty($notifications))
        {
            return 0;
        }

        $this->message_producer->open($exchange_name);

        $published_messages = 0;
        /** @var Notification $last_published_notification */
        $last_published_notification = null;

        try
        {
            foreach ($notifications as $notification)
            {
                $this->message_producer->send($exchange_name, $notification);

                $published_messages++;
                $last_published_notification = $notification;
            }
        }
        catch(\Exception $e) {}

        if ($published_messages > 0)
        {
            $this->published_message_repository->trackMostRecentPublishedMessage(
                $exchange_name,
                $last_published_notification
            );
        }

        $this->message_producer->close($exchange_name);

        return $published_messages;
    }
}