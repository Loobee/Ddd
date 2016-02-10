<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\DddBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Loobee\Ddd\DddBundle\DependencyInjection\LoobeeDddExtension;
use Loobee\Ddd\DddBundle\DependencyInjection\Compiler\RegisterSubscribers;

class LoobeeDddBundle extends Bundle implements LoobeeDddBundleStructureInterface
{
    public function getContainerExtension()
    {
        return new LoobeeDddExtension();
    }

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(
            new RegisterSubscribers(
                'loobee_ddd.ddd_bundle.event_listener.event_manager_listener',
                'loobee_ddd.event_subscriber'
            )
        );
    }
}