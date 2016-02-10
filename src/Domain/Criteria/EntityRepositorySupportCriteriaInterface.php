<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

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