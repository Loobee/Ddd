<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Criteria;

class Criteria
{
    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $rows_per_page;

    /**
     * @var FieldFilter[]
     */
    private $field_filters = [];

    /**
     * @var FieldOrder[]
     */
    private $field_orders = [];

    /**
     * @param int $page
     * @param int $rows_per_page
     */
    public function __construct($page = 1, $rows_per_page = 10)
    {
        $this->setPage($page);
        $this->rows_per_page = $rows_per_page;
    }


    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return Criteria
     */
    public function setPage($page)
    {
        if ($page < 1)
        {
            $page = 1;
        }

        $this->page = $page;

        return $this;
    }

    /**
     * @return int
     */
    public function getRowsPerPage()
    {
        return $this->rows_per_page;
    }

    /**
     * @param int $rows_per_page
     *
     * @return Criteria
     */
    public function setRowsPerPage($rows_per_page)
    {
        $this->rows_per_page = $rows_per_page;

        return $this;
    }

    /**
     * @return FieldFilter[]
     */
    public function getFieldFilters()
    {
        return $this->field_filters;
    }

    /**
     * @param FieldFilter $field_filter
     *
     * @return Criteria
     */
    public function addFieldFilter(FieldFilter $field_filter)
    {
        $this->field_filters[] = $field_filter;

        return $this;
    }

    /**
     * @return FieldOrder[]
     */
    public function getFieldOrders()
    {
        return $this->field_orders;
    }

    /**
     * @param FieldOrder $field_order
     *
     * @return Criteria
     */
    public function addFieldOrder(FieldOrder $field_order)
    {
        $this->field_orders[] = $field_order;

        return $this;
    }
}