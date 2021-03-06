<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Criteria;

abstract class Field
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param $name
     *
     * @throws InvalidCriteriaFieldNameException
     */
    abstract protected function assertFieldIsValid($name);

    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->assertFieldIsValid($name);

        $this->name = $name;
    }

    /**
     * @return string
     */
    final public function getName()
    {
        return $this->name;
    }
}