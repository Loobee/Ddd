<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain;

interface EntityRepositoryInterface
{
    /**
     * @param $id
     *
     * @return bool
     */
    function exist($id);

    /**
     * @param $id
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