<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\DddBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Loobee\Ddd\Application\Service\TransactionalApplicationServiceAdapter;

class RegisterTransactionCommands implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $tag_name;

    /**
     * @param string $tag_name
     */
    public function __construct($tag_name)
    {
        $this->tag_name = $tag_name;
    }

    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds($this->tag_name) as $service_id => $tags)
        {
            $this->wrapTransaction($container, $service_id);
        }
    }

    protected function wrapTransaction(ContainerBuilder $container, $service_id)
    {
        $original_name = $service_id . '_original';

        $original = clone $container->findDefinition($service_id);
        $original->setPublic(false);

        $transaction = new Definition(TransactionalApplicationServiceAdapter::class, [
            new Reference($original_name),
            new Reference('loobee_ddd.application.service.doctrine_session'),
            new Reference('loobee_ddd.domain.event.event_manager')
        ]);

        //$container->removeDefinition($service_id);
        $container->setDefinition($original_name, $original);
        $container->setDefinition($service_id, $transaction);
    }
}