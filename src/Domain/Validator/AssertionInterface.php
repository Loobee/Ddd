<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Validator;

interface AssertionInterface
{
    /**
     * @param string $value
     *
     * @throws InvalidArgumentException
     */
    public function isUuid($value);

    /**
     * @param string $value
     * @param integer $min_length
     *
     * @throws InvalidArgumentException
     */
    public function hasMinLength($value, $min_length);

    /**
     * @param mixed $object
     * @param string $class_name
     *
     * @throws InvalidArgumentException
     */
    public function assertInstanceOf($object, $class_name);

    /**
     * @param $value
     * @param array $choices
     *
     * @throws InvalidArgumentException
     */
    public function assertInArray($value, array $choices);
}