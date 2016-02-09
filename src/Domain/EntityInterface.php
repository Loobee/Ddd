<?php

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