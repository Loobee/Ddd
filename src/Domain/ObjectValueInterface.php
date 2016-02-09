<?php

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