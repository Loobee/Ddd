<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Application\Assembler;

use Loobee\Ddd\Infrastructure\Resource\Domain\Model\ResourceInterface;
use Loobee\Ddd\Domain\EntityInterface;
use Loobee\Ddd\Domain\ObjectValueInterface;

interface AssemblerInterface
{
    /**
     * @param EntityInterface|ObjectValueInterface $data_object
     *
     * @return ResourceInterface
     */
    function toResource($data_object);

    /**
     * @param ResourceInterface $resource
     *
     * @return EntityInterface|ObjectValueInterface
     */
    function toDataObject(ResourceInterface $resource);
}