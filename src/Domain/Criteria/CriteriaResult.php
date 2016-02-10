<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Criteria;

use Loobee\Ddd\Domain\EntityInterface;

class CriteriaResult
{
    /**
     * @var EntityInterface[]
     */
    protected $entities;

    /**
     * @var int
     */
    private $total_entities;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $rows_per_page;

    /**
     * @var int
     */
    private $num_pages;

    /**
     * @param EntityInterface[] $entities
     * @param int $total_entities
     * @param int $page
     * @param int $rows_per_page
     * @param int $num_pages
     */
    public function __construct(array $entities, $total_entities, $page, $rows_per_page, $num_pages)
    {
        $this->entities       = $entities;
        $this->total_entities = $total_entities;
        $this->page           = $page;
        $this->rows_per_page  = $rows_per_page;
        $this->num_pages      = $num_pages;
    }

    /**
     * @return EntityInterface[]
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @return int
     */
    public function getTotalEntities()
    {
        return $this->total_entities;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getRowsPerPage()
    {
        return $this->rows_per_page;
    }

    /**
     * @return int
     */
    public function getNumPages()
    {
        return $this->num_pages;
    }
}