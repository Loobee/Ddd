<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Model\Identifier;

class IdentifierService
{
    /**
     * @var IdentityBuilderInterface
     */
    private $identity_builder;

    /**
     * @param IdentityBuilderInterface $identity_builder
     */
    public function __construct(IdentityBuilderInterface $identity_builder)
    {
        $this->identity_builder = $identity_builder;
    }

    /**
     * @return Identity
     */
    public function generateIdentity()
    {
        return $this->identity_builder->build();
    }
}