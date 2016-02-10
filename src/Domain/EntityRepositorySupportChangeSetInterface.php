<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain;

interface EntityRepositorySupportChangeSetInterface
{
    /**т
     * @param EntityInterface $entity
     *
     * @return array
     */
    function changeSet(EntityInterface $entity);
}