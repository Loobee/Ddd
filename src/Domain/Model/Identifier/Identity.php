<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Model\Identifier;

use Loobee\Ddd\Domain\ObjectValueInterface;

class Identity implements ObjectValueInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    public function isEqual(ObjectValueInterface $object_value = null)
    {
        if (is_null($object_value) || get_class($object_value) != static::class)
        {
            return false;
        }

        /** @var Identity $object_value */
        return $this->id == $object_value->id;
    }

    public function __toString()
    {
        return $this->id;
    }
}