<?php

namespace Tkotosz\CliAppBuilder\Configurator;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use Tkotosz\CliAppBuilder\CliAppConfig;

class AutoServiceRegistrationConfigurator implements ConfiguratorInterface
{
    /**
     * @var string
     */
    private $namespace;
    
    /**
     * @var string
     */
    private $resource;
    
    /**
     * @var string|null
     */
    private $exclude;
    
    /**
     * @param string $namespace
     * @param string $resource
     * @param string|null $exclude
     */
    public function __construct(string $namespace, string $resource, ?string $exclude = null)
    {
        $this->namespace = $namespace;
        $this->resource = $resource;
        $this->exclude = $exclude;
    }
    
    public function configure(ContainerBuilder $containerBuilder, CliAppConfig $cliAppConfig)
    {
        $loader = new GlobFileLoader($containerBuilder, new FileLocator(__DIR__));

        $definition = new Definition();
        $definition
            ->setAutowired(true)
            ->setAutoconfigured(true)
            ->setPublic(false);

        $loader->registerClasses($definition, $this->namespace, $this->resource, $this->exclude);
    }
}
