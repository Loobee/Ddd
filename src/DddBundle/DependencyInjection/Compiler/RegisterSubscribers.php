<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\DddBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterSubscribers implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $auto_subscriber_service_id;

    /**
     * @var string
     */
    private $tag_name;

    /**
     * @param string $auto_subscriber_service_id
     * @param string $tag_name
     */
    public function __construct($auto_subscriber_service_id, $tag_name)
    {
        $this->auto_subscriber_service_id = $auto_subscriber_service_id;
        $this->tag_name = $tag_name;
    }

    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition($this->auto_subscriber_service_id);

        $references = [];

        foreach ($container->findTaggedServiceIds($this->tag_name) as $service_id => $tags)
        {
            $references[] = new Reference($service_id);
        }

        $definition->replaceArgument(0, $references);
    }
}