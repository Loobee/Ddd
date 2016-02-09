<?php

namespace Loobee\Ddd\Domain\Validator;

abstract class Validator
{
    /**
     * @var AssertionInterface
     */
    protected $assertion;

    public function setAssertion(AssertionInterface $assertion)
    {
        $this->assertion = $assertion;
    }

    /**
     * @param mixed $object
     *
     * @throws InvalidArgumentException
     */
    abstract public function validate($object);
}