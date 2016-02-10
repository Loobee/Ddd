<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain;

trait EntityAutoImplementationTrait
{
    /**
     * @var string
     */
    private $id;

    /**
     * @return string
     */
    final public function getId()
    {
        return $this->id;
    }

    /**
     * @param EntityInterface $entity
     *
     * @return bool
     */
    public function isEqual(EntityInterface $entity)
    {
        if (get_class($entity) != static::class)
        {
            return false;
        }

        return $this->getId() == $entity->getId();
    }
}