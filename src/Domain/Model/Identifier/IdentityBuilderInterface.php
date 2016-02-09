<?php

namespace Loobee\Ddd\Domain\Model\Identifier;

interface IdentityBuilderInterface
{
    /**
     * @return Identity
     */
    public function build();
}