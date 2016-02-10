<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Application\Assembler;

class AssemblerCollectionAdapter implements AssemblerCollectionInterface
{
    /**
     * @var AssemblerInterface
     */
    private $assembler;

    /**
     * @param AssemblerInterface $assembler
     */
    public function __construct(AssemblerInterface $assembler)
    {
        $this->assembler = $assembler;
    }

    function toResource(array $data_objects)
    {
        return array_map(function ($object)
        {
            return $this->assembler->toResource($object);

        }, $data_objects);
    }

    function toDataObject(array $resources)
    {
        return array_map(function ($resource)
        {
            return $this->assembler->toDataObject($resource);

        }, $resources);
    }
}