<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Event;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Менеджер событий домена.
 */
class EventManager
{
    /**
     * @var EventSubscriberInterface[] Подписчики
     */
    private $subscribers = [];

    /**
     * @var EventContainerInterface[]
     */
    private $event_containers = [];

    /**
     * Добавить подписчика.
     *
     * @param EventSubscriberInterface $subscriber
     *
     * @return integer ID подписчика.
     */
    public function subscribe(EventSubscriberInterface $subscriber)
    {
        static $id = 0;

        $this->subscribers[$id] = $subscriber;

        return $id++;
    }


    /**
     * Удалить подписчика.
     *
     * @param integer $id ID подписчика
     */
    public function unsubscribe($id)
    {
        unset($this->subscribers[$id]);
    }

    /**
     * Оповестить подписчиков о наступлении события.
     *
     * @param EventInterface $event
     */
    public function publish(EventInterface $event)
    {
        foreach ($this->subscribers as $subscriber)
        {
            if ($subscriber->isSubscribedTo($event))
            {
                $subscriber->handle($event);
            }
        }
    }

    /**
     * @param EventContainerInterface $event_container
     */
    public function registerEventContainer(EventContainerInterface $event_container)
    {
        if (!in_array($event_container, $this->event_containers))
        {
            $this->event_containers[] = $event_container;
        }
    }

    public function publishEventContainers()
    {
        foreach($this->event_containers as $event_container)
        {
            $events = $event_container->getEvents();

            $event_container->eraseEvents();

            foreach($events as $event)
            {
                $this->publish($event);
            }
        }
    }

    public function cleanEventContainers()
    {
        foreach($this->event_containers as $event_container)
        {
            $event_container->eraseEvents();
        }
    }
}