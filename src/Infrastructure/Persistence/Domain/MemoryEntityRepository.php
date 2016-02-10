<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Infrastructure\Persistence\Domain;

use Loobee\Ddd\Domain\EntityInterface;
use Loobee\Ddd\Domain\EntityRepositoryInterface;
use Loobee\Ddd\Domain\EntityRepositorySupportChangeSetInterface;
use Loobee\Ddd\Domain\Criteria\EntityRepositorySupportCriteriaInterface;
use Loobee\Ddd\Domain\Criteria\Criteria;
use Loobee\Ddd\Domain\Criteria\CriteriaResult;

abstract class MemoryEntityRepository implements
    EntityRepositoryInterface,
    EntityRepositorySupportChangeSetInterface,
    EntityRepositorySupportCriteriaInterface
{
    /**
     * @var EntityInterface[]
     */
    protected $entities;

    /**
     * @param EntityInterface[] $entities
     */
    public function __construct(array $entities)
    {
        $this->entities = $entities;
    }

    public function find($id)
    {
        if (isset($this->entities[$id]))
        {
            return $this->entities[$id];
        }

        return null;
    }

    public function findAll()
    {
        return $this->entities;
    }

    public function save(EntityInterface $entity)
    {
        $this->entities[$entity->getId()] = $entity;
    }

    public function changeSet(EntityInterface $entity)
    {
        return [];
    }

    public function findByCriteria(Criteria $criteria)
    {
        return new CriteriaResult(
            $this->entities,
            count($this->entities),
            $criteria->getPage(),
            $criteria->getRowsPerPage(),
            ceil(count($this->entities) / $criteria->getRowsPerPage())
        );
    }
}