<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain;

interface ObjectValueInterface
{
    /**
     * @param ObjectValueInterface $object_value
     *
     * @return bool
     */
    function isEqual(ObjectValueInterface $object_value = null);

    /**
     * @return string
     */
    function __toString();
}