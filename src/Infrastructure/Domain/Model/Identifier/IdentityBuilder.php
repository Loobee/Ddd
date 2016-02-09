<?php

namespace Loobee\Ddd\Infrastructure\Domain\Model\Identifier;

use Loobee\Ddd\Domain\Model\Identifier\Identity;
use Loobee\Ddd\Domain\Model\Identifier\IdentityBuilderInterface;
use Ramsey\Uuid\Uuid;

class IdentityBuilder implements IdentityBuilderInterface
{
    /**
     * @return Identity
     */
    public function build()
    {
        return new Identity(Uuid::uuid4()->toString());
    }
}