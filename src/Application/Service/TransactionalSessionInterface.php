<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Application\Service;

interface TransactionalSessionInterface
{
    /**
     * @param callable $operation
     *
     * @return mixed
     */
    public function executeAtomically(callable $operation);
}