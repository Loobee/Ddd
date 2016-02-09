<?php

namespace Loobee\Ddd\Domain\Validator;

use Loobee\Ddd\Domain\Exception\DomainException;

class InvalidArgumentException extends DomainException
{
    public function __construct($message, $code, $property_path = '', $value = null, $constraints = [])
    {
        parent::__construct($message, $code);
    }
}