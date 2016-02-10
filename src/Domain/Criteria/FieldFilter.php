<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Criteria;

class FieldFilter
{
    const kEqualOperation          = ' = ';
    const kGreaterOperation        = ' > ';
    const kGreaterOrEqualOperation = ' >= ';
    const kLessOperation           = ' < ';
    const kLessOrEqualOperation    = ' <= ';
    const kLikeOperation           = ' LIKE ';

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $operation;

    /**
     * @var string
     */
    private $value;

    /**
     * @param Field  $field
     * @param string $operation
     * @param string $value
     */
    public function __construct(Field $field, $operation, $value)
    {
        $this->field     = $field->getName();
        $this->operation = $operation;
        $this->value     = $value;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}