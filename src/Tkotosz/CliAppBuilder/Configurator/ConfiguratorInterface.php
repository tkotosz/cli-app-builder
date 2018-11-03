<?php

namespace Tkotosz\CliAppBuilder\Configurator;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tkotosz\CliAppBuilder\CliAppConfig;

interface ConfiguratorInterface
{
    public function configure(ContainerBuilder $containerBuilder, CliAppConfig $cliAppConfig);
}
