<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Criteria;

use Loobee\Ddd\Domain\Exception\DomainException;

class InvalidCriteriaFieldNameException extends DomainException
{
    public function __construct($field)
    {
        parent::__construct('Invalid criteria field name: ' . $field);
    }
}