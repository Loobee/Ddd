<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Application\Notification;

use Loobee\Ddd\Domain\EntityInterface;
use Loobee\Ddd\Domain\EntityAutoImplementationTrait;

class PublishedMessage implements EntityInterface
{
    use EntityAutoImplementationTrait;

    /**
     * @var integer
     */
    private $most_recent_published_message_id;

    /**
     * @var string
     */
    private $type_name;

    /**
     * @param string   $type_name
     * @param integer  $most_recent_published_message_id
     */
    public function __construct($type_name, $most_recent_published_message_id)
    {
        $this->type_name = $type_name;
        $this->most_recent_published_message_id = $most_recent_published_message_id;
    }

    /**
     * @return int
     */
    public function getMostRecentPublishedMessageId()
    {
        return $this->most_recent_published_message_id;
    }

    /**
     * @param int $most_recent_published_message_id
     */
    public function setMostRecentPublishedMessageId($most_recent_published_message_id)
    {
        $this->most_recent_published_message_id = $most_recent_published_message_id;
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        return $this->type_name;
    }
}