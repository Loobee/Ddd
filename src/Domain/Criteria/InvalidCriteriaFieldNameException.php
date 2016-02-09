<?php

namespace Loobee\Ddd\Domain\Criteria;

use Loobee\Ddd\Domain\Exception\DomainException;

class InvalidCriteriaFieldNameException extends DomainException
{
    public function __construct($field)
    {
        parent::__construct('Invalid criteria field name: ' . $field);
    }
}