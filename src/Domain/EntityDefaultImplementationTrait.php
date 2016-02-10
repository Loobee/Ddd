<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain;

use Loobee\Ddd\Domain\Model\Identifier\Identity;

trait EntityDefaultImplementationTrait
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
     * @param Identity $id
     */
    final protected function setId(Identity $id)
    {
        $this->id = (string)$id;
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