<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Validator;

use Loobee\Ddd\Domain\Exception\DomainException;

class InvalidArgumentException extends DomainException
{
    public function __construct($message, $code, $property_path = '', $value = null, $constraints = [])
    {
        parent::__construct($message, $code);
    }
}