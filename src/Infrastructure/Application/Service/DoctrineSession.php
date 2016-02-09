<?php

namespace Loobee\Ddd\Infrastructure\Application\Service;

use Loobee\Ddd\Application\Service\TransactionalSessionInterface;
use Doctrine\ORM\EntityManager;

class DoctrineSession implements TransactionalSessionInterface
{
    /**
     * @var EntityManager
     */
    private $entity_manager;

    /**
     * @param EntityManager $entity_manager
     */
    public function __construct(EntityManager $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    public function executeAtomically(callable $operation)
    {
        return $this->entity_manager->transactional($operation);
    }
}