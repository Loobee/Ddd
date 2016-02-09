<?php

namespace Loobee\Ddd\Domain;

interface EntityRepositoryInterface
{
    /**
     * @param string $id
     *
     * @return EntityInterface|null
     */
    function find($id);

    /**
     * @return EntityInterface[]
     */
    function findAll();

    /**
     * @param EntityInterface $entity
     */
    function save(EntityInterface $entity);
}