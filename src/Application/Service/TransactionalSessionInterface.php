<?php

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