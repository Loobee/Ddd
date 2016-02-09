<?php

namespace Loobee\Ddd\DddBundle\DependencyInjection;

use Exception;
use ReflectionClass;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\Config\FileLocator;
use Loobee\Ddd\DddBundle\LoobeeDddBundleStructureInterface;
use Loobee\Ddd\Infrastructure\Persistence\Doctrine\Types\ObjectValueSampleArray;

class LoobeeDddExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();

        $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('bundle-services.yml');
        $loader->load('domain-builders.yml');
        $loader->load('domain-services.yml');
        $loader->load('infrastructure-builders.yml');
        $loader->load('infrastructure-services.yml');
        $loader->load('repositories.yml');
        $loader->load('subscribers.yml');
        $loader->load('validators.yml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $configs     = $container->getExtensionConfig('doctrine');
        $bundles     = $container->getParameter('kernel.bundles');
        $mappings    = $configs[0]['orm']['mappings'];
        $new_mapping = [];

        $mapping_path = '/Infrastructure/Persistence/Doctrine/Resources/mapping';

        foreach($bundles as $bundle_name => $bundle_class)
        {
            if (isset($mappings[$bundle_name]))
            {
                continue;
            }

            $reflector = new ReflectionClass($bundle_class);

            if (!$reflector->implementsInterface(LoobeeDddBundleStructureInterface::class))
            {
                continue;
            }

            preg_match("/^(.+)\\\\([^\\\\]+)Bundle$/si", $reflector->getNamespaceName(), $math);

            $prefix_ns = substr($math[1], 0, strrpos($math[1], $math[2])) . $math[2];
            $prefix_path = DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $prefix_ns);

            $dir = substr($reflector->getFileName(), 0, strrpos($reflector->getFileName(), 'src')) . 'src';

            if (false === strrpos($dir, $prefix_path))
            {
                $dir .= $prefix_path;
            }

            $dir .= $mapping_path;

            $new_mapping[$bundle_name] = [
                'type'      => 'yml',
                'dir'       => $dir,
                'prefix'    => $prefix_ns,
                'is_bundle' => false,
            ];
        }

        $container->prependExtensionConfig('doctrine', [
            'orm' => [
                'entity_managers' => [
                    'default' => [
                        'mappings' => $new_mapping
                    ]
                ]
            ]
        ]);

        $container->prependExtensionConfig('doctrine', [
            'dbal' => [
                'types' => [
                    'object_value_sample_array' => ObjectValueSampleArray::class
                ]
            ]
        ]);
    }
}