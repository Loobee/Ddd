<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Infrastructure\Persistence\Domain;

use Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository as DoctrineBaseEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Loobee\Ddd\Domain\EntityInterface;
use Loobee\Ddd\Domain\EntityRepositoryInterface;
use Loobee\Ddd\Domain\EntityRepositorySupportChangeSetInterface;
use Loobee\Ddd\Domain\Criteria\EntityRepositorySupportCriteriaInterface;
use Loobee\Ddd\Domain\Criteria\Criteria;
use Loobee\Ddd\Domain\Criteria\FieldFilter;
use Loobee\Ddd\Domain\Criteria\CriteriaResult;

abstract class DoctrineEntityRepository implements
    EntityRepositoryInterface,
    EntityRepositorySupportChangeSetInterface,
    EntityRepositorySupportCriteriaInterface
{
    /**
     * @var EntityManager
     */
    private $entity_manager;

    /**
     * @var DoctrineBaseEntityRepository
     */
    private $entity_repository;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entity_manager    = $entity_manager;
        $this->entity_repository = $this->entity_manager->getRepository($this->getEntity());
    }

    /**
     * @return DoctrineBaseEntityRepository
     */
    protected function getEntityRepository()
    {
        return $this->entity_repository;
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entity_manager;
    }

    /**
     * @return string
     */
    abstract protected function getEntity();

    public function find($id)
    {
        return $this->getEntityRepository()->findOneById($id);
    }

    public function findAll()
    {
        return $this->getEntityRepository()->findAll();
    }

    /**
     * @param EntityInterface $entity
     *
     * @throws EntityRepositoryException
     */
    public function save(EntityInterface $entity)
    {
        try
        {
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();
        }
        catch(Exception $e)
        {
            throw new EntityRepositoryException(sprintf('Error on save %s entity', $this->getEntity()));
        }
    }

    public function changeSet(EntityInterface $entity)
    {
        $uow = $this->getEntityManager()->getUnitOfWork();

        $uow->computeChangeSets();

        return $uow->getEntityChangeSet($entity);
    }

    public function findByCriteria(Criteria $criteria)
    {
        $query_builder = $this->getEntityRepository()->createQueryBuilder('e')->select('e');

        foreach ($criteria->getFieldFilters() as $index => $field_filter)
        {
            $this->addFieldFilterToQuery($query_builder, $index, $field_filter);
        }

        $paginator = new Paginator($query_builder->getQuery(), false);
        $total_entities = $paginator->count();
        $pages_count = ceil($total_entities / $criteria->getRowsPerPage());

        return new CriteriaResult(
            $this->getPageResult($paginator, $criteria),
            $total_entities,
            $criteria->getPage(),
            $criteria->getRowsPerPage(),
            $pages_count
        );
    }

    /**
     * @param Paginator $paginator
     * @param Criteria $criteria
     *
     * @return array
     */
    private function getPageResult(Paginator $paginator, Criteria $criteria)
    {
        return $paginator
            ->getQuery()
            ->setFirstResult($criteria->getRowsPerPage() * ($criteria->getPage() - 1))
            ->setMaxResults($criteria->getRowsPerPage())
            ->getResult();
    }

    /**
     * @param QueryBuilder $query_builder
     * @param int $index*
     * @param FieldFilter $field_filter
     */
    private function addFieldFilterToQuery(QueryBuilder $query_builder, $index, FieldFilter $field_filter)
    {
        $where = 0 === $index ? 'where' : 'andWhere';

        $condition  = 'e.' . $field_filter->getField();
        $condition .= $field_filter->getOperation();
        $condition .= ':' . $field_filter->getField();

        $query_builder->$where($condition)
            ->setParameter(
                $field_filter->getField(),
                $field_filter->getValue()
            );
    }
}