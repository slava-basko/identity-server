<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ApiServicesCompiler implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('rpc_service_manager')) {
            return;
        }

        $apiServiceManagerDefinition = $container->findDefinition('rpc_service_manager');

        $taggedServices = $container->findTaggedServiceIds('rpc.service');
        foreach ($taggedServices as $id => $apiService) {
            $apiServiceManagerDefinition->addMethodCall('addApiService', [new Reference($id)]);
        }
    }
}