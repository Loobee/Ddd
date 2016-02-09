<?php

namespace Loobee\Ddd\Infrastructure\Resource\View;

/**
 * @see http://www.binpress.com/tutorial/custom-pagination-in-php-and-symfony/117
 */
class Paginator
{
    const kDefaultFirstFivePagesArray = [1, 2, 3, 4, 5];
    const kDefaultRowsPerPage = 20;
    const kMinimumFirstPages = 5;
    const kFirstPageNumber = 1;

    /**
     * @var float
     */
    private $total_pages;

    /**
     * @var int
     */
    private $page;

    /**
     * @param int $page
     * @param int $total_count
     * @param int $rows_per_page
     */
    public function __construct($page, $total_count, $rows_per_page = self::kDefaultRowsPerPage)
    {
        $this->page = $page;

        $this->setTotalPages($total_count, $rows_per_page);
    }

    /**
     * @return float
     */
    public function getTotalPages()
    {
        return $this->total_pages;
    }

    /**
     * @param int $total_count
     * @param int $rows_per_page
     */
    private function setTotalPages($total_count, $rows_per_page)
    {
        $this->total_pages = ceil($total_count / $rows_per_page);
    }

    public function getPagesList()
    {
        if ($this->total_pages <= self::kMinimumFirstPages)
        {
            return self::kDefaultFirstFivePagesArray;
        }

        if ($this->page <= 3)
        {
            return self::kDefaultFirstFivePagesArray;
        }

        $result = [];

        $i    = self::kMinimumFirstPages;
        $half = floor(self::kMinimumFirstPages / 2);

        if ($this->page + $half > $this->total_pages)
        {
            while($i >= 1)
            {
                $result[] = $this->total_pages - $i + 1;
                $i--;
            }
        }
        else
        {
            while($i >= 1)
            {
                $result[] = $this->page - $i + $half + 1;
                $i--;
            }
        }

        return $result;
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
    public function getPreviousPage()
    {
        return $this->page <= self::kFirstPageNumber ? self::kFirstPageNumber : $this->getPage() - 1;
    }

    /**
     * @return int
     */
    public function getNextPage()
    {
        return $this->page >= $this->getTotalPages() ? $this->getTotalPages() : $this->getPage() + 1;
    }
}