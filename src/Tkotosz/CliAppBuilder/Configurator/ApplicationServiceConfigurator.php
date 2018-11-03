<?php

namespace Tkotosz\CliAppBuilder\Configurator;

use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Tkotosz\CliAppBuilder\CliAppConfig;

class ApplicationServiceConfigurator implements ConfiguratorInterface
{
    public function configure(ContainerBuilder $containerBuilder, CliAppConfig $cliAppConfig)
    {
        $appDefinition = new Definition(
            Application::class,
            [$cliAppConfig->getApplicationName(), $cliAppConfig->getApplicationVersion()]
        );
        $appDefinition->setPublic(true);

        $containerBuilder->setDefinition($cliAppConfig->getApplicationId(), $appDefinition);
    }
}
