<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

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