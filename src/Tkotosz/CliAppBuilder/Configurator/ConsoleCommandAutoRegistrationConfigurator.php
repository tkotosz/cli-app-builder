<?php

namespace Tkotosz\CliAppBuilder\Configurator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tkotosz\CliAppBuilder\CliAppConfig;
use Tkotosz\CliAppBuilder\Configurator\ConfiguratorInterface;
use Tkotosz\CliAppBuilder\ServiceContainer\DependencyInjection\CompilerPass\AutoRegisterTaggedServicesCompilerPass;

class ConsoleCommandAutoRegistrationConfigurator implements ConfiguratorInterface
{
    public function configure(ContainerBuilder $containerBuilder, CliAppConfig $cliAppConfig)
    {
        $containerBuilder->registerForAutoconfiguration(Command::class)->addTag('console.command');
        $containerBuilder->addCompilerPass(
            new AutoRegisterTaggedServicesCompilerPass(
                'console.command',
                $cliAppConfig->getApplicationId(),
                'add'
            )
        );
    }
}
