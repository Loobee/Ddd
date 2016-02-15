<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Criteria;

class FieldOrder
{
    const kSortDescending = 'DESC';
    const kSortAscending  = 'ASC';

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $sort_type;

    /**
     * @param Field  $field
     * @param string $sort_type
     */
    public function __construct(Field $field, $sort_type)
    {
        $this->field     = $field->getName();
        $this->sort_type = $sort_type;
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
    public function getSortType()
    {
        return $this->sort_type;
    }
}