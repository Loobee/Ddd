<?php

namespace Loobee\Ddd\Domain\Criteria;

interface EntityRepositorySupportCriteriaInterface
{
    /**
     * @param Criteria $criteria
     *
     * @return CriteriaResult
     */
    public function findByCriteria(Criteria $criteria);
}