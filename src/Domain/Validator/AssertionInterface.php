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

    /**
     * @param $value
     *
     * @throws InvalidArgumentException
     */
    public function assertNotNull($value);

    /**
     * @param $value
     *
     * @throws InvalidArgumentException
     */
    public function isInteger($value);

    /**
     * @param $value
     *
     * @throws InvalidArgumentException
     */
    public function isFloat($value);

    /**
     * @param $value
     * @param integer $min
     * @param integer $max
     *
     * @throws InvalidArgumentException
     */
    public function inRange($value, $min, $max);

    /**
     * @param $value1
     * @param $value2
     *
     * @throws InvalidArgumentException
     */
    public function assertEq($value1, $value2);
}