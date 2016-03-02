<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Criteria;

use Loobee\Ddd\Domain\EntityInterface;

class CriteriaBuilder
{
    /**
     * @var Criteria
     */
    private $criteria;

    /**
     * @param int $page
     * @param int $rows_per_page
     */
    public function __construct($page = 1, $rows_per_page = 10)
    {
        $this->criteria = new Criteria($page, $rows_per_page);
    }

    public function addFilter(Field $field, $value, $operation, $template = null)
    {
        if ($value instanceof EntityInterface)
        {
            $value = $value->getId();
        }

        if (!empty($template))
        {
            $value = sprintf($template, $value);
        }

        $this->criteria->addFieldFilter(new FieldFilter($field, $operation, $value));
    }

    /**
     * @param Field $field
     * @param $value
     * @param $operation
     * @param string $template
     */
    public function addFilterIfValueNotEmpty(Field $field, $value, $operation, $template = null)
    {
        if (empty($value))
        {
            return;
        }

        $this->addFilter($field, $value, $operation, $template);
    }

    /**
     * @param Field $field
     * @param $order_type
     */
    public function addOrder(Field $field, $order_type)
    {
        $this->criteria->addFieldOrder(new FieldOrder($field, $order_type));
    }

    /**
     * @return Criteria
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
}