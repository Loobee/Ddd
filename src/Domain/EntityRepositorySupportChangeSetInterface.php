<?php

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