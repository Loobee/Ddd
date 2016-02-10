<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Infrastructure\Domain\Validator;

use Assert\Assertion;
use Loobee\Ddd\Domain\Validator\AssertionInterface;
use Loobee\Ddd\Domain\Validator\InvalidArgumentException;

class AssertionAdapter extends Assertion implements AssertionInterface
{
    protected static $exceptionClass;

    public function __construct()
    {
        static::$exceptionClass = InvalidArgumentException::class;
    }

    public function isUuid($value)
    {
        parent::uuid($value);
    }

    public function hasMinLength($value, $min_length)
    {
        parent::minLength($value, $min_length);
    }

    public function assertInstanceOf($object, $class_name)
    {
        parent::isInstanceOf($object, $class_name);
    }

    public function assertInArray($value, array $choices)
    {
        parent::inArray($value, $choices);
    }
}