<?php

namespace Loobee\Ddd\DddBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $tree_builder = new TreeBuilder();

        $tree_builder->root('loobee_ddd');

        return $tree_builder;
    }
}