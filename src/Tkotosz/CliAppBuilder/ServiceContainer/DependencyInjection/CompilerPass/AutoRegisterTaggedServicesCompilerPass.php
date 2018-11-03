<?php

namespace Tkotosz\CliAppBuilder\ServiceContainer\DependencyInjection\CompilerPass;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class AutoRegisterTaggedServicesCompilerPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $serviceTag;
    
    /**
     * @var string
     */
    private $masterServiceId;
    
    /**
     * @var string
     */
    private $masterServiceRegisterServiceMethod;
    
    /**
     * @param string $serviceTag
     * @param string $masterServiceId
     * @param string $masterServiceRegisterServiceMethod
     */
    public function __construct(
        string $serviceTag,
        string $masterServiceId,
        string $masterServiceRegisterServiceMethod
    ) {
        $this->serviceTag = $serviceTag;
        $this->masterServiceId = $masterServiceId;
        $this->masterServiceRegisterServiceMethod = $masterServiceRegisterServiceMethod;
    }
    
    public function process(ContainerBuilder $containerBuilder): void
    {
        if (!$containerBuilder->has($this->masterServiceId)) {
            return;
        }
        
        $masterServiceDefinition = $containerBuilder->getDefinition($this->masterServiceId);
        $taggedServices = $containerBuilder->findTaggedServiceIds($this->serviceTag);

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $masterServiceDefinition->addMethodCall(
                    $this->masterServiceRegisterServiceMethod,
                    [
                        new Reference($id),
                        $attributes["alias"] ?? null
                    ]
                );
            }
        }
    }
}
