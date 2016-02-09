<?php

namespace Loobee\Ddd\Application\Notification;

use DateTime;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\Serializer;
use Loobee\Ddd\Domain\EntityInterface;
use Loobee\Ddd\Domain\EntityAutoImplementationTrait;
use Loobee\Ddd\Domain\Event\EventInterface;

class Notification implements EntityInterface
{
    use EntityAutoImplementationTrait;

    const kFormatType = 'json';

    /**
     * @var DateTime
     */
    private $occurred_on;

    /**
     * @var string
     */
    private $event_type;

    /**
     * @var string
     */
    private $event_body;

    /**
     * @param EventInterface $event
     */
    public function __construct(EventInterface $event)
    {
        $this->occurred_on = $event->getOccurredOn();
        $this->event_type  = get_class($event);
        $this->event_body  = self::getSerializer()->serialize($event, self::kFormatType);
    }

    /**
     * @return DateTime
     */
    public function getOccurredOn()
    {
        return $this->occurred_on;
    }

    /**
     * @return string
     */
    public function getEventType()
    {
        return $this->event_type;
    }

    /**
     * @return string
     */
    public function getEventBody()
    {
        return $this->event_body;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        self::getEventFromBody($this->event_type, $this->event_body);
    }

    /**
     * @return Serializer
     */
    private static function getSerializer()
    {
        static $serializer = null;

        return $serializer = $serializer ?? SerializerBuilder::create()->build();
    }

    /**
     * @param string $type
     * @param string $body
     *
     * @return mixed
     */
    public static function getEventFromBody($type, $body)
    {
        return self::getSerializer()->deserialize($body, $type, self::kFormatType);
    }
}
