<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Application\Assembler;

use Loobee\Ddd\Infrastructure\Resource\Domain\Model\ResourceInterface;
use Loobee\Ddd\Domain\EntityInterface;
use Loobee\Ddd\Domain\ObjectValueInterface;

interface AssemblerCollectionInterface
{
    /**
     * @param EntityInterface[]|ObjectValueInterface[] $data_objects
     *
     * @return ResourceInterface[]
     */
    function toResource(array $data_objects);

    /**
     * @param ResourceInterface[] $resources
     *
     * @return EntityInterface[]|ObjectValueInterface[]
     */
    function toDataObject(array $resources);
}