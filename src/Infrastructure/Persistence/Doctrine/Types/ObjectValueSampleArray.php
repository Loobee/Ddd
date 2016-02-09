<?php

namespace Loobee\Ddd\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonArrayType;
use Loobee\Ddd\Domain\ObjectValueInterface;

class ObjectValueSampleArray extends JsonArrayType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $type = get_class($value[0]);
        $arr  = array_map(function(ObjectValueInterface $object_value)
        {
            return (string)$object_value;
        }, $value);

        return json_encode([
            'type' => $type,
            'data' => $arr,
        ]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = json_decode($value, true);

        $type = $value['type'];
        $data = $value['data'];

        return array_map(function($value) use($type)
        {
            return new $type($value);

        }, $data);
    }

    public function getName()
    {
        return 'object_value_sample_array';
    }
}