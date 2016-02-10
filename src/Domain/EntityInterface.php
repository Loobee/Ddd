<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain;

interface EntityInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @param EntityInterface $entity
     *
     * @return bool
     */
    public function isEqual(EntityInterface $entity);
}