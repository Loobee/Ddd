<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain;

use Loobee\Ddd\Domain\Model\Identifier\Identity;

/**
 * Оптимистическая блокировка.
 *
 * @see http://doctrine-orm.readthedocs.org/projects/doctrine-orm/en/latest/reference/transactions-and-concurrency.html#optimistic-locking
 *
 * yml конфигурация:
 *   fields:
 *     version:
 *       type: integer
 *       version:
 *         type: integer
 *         default: 1
 */
trait EntityOptimisticLockingTrait
{
    /**
     * @var int
     */
    private $version;

    /**
     * Версия сущности.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }
}