<?php

namespace Tkotosz\CliAppBuilder;

use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tkotosz\CliAppBuilder\CliAppConfig;
use Tkotosz\CliAppBuilder\Configurator\ApplicationServiceConfigurator;
use Tkotosz\CliAppBuilder\Configurator\AutoServiceRegistrationConfigurator;
use Tkotosz\CliAppBuilder\Configurator\ConfiguratorInterface;
use Tkotosz\CliAppBuilder\Configurator\ConsoleCommandAutoRegistrationConfigurator;

class CliAppBuilder
{
    /**
     * @var CliAppConfig
     */
    private $config;

    /**
     * @var ConfiguratorInterface[]
     */
    private $configurators = [];

    public function __construct()
    {
        $this->reset();
    }
    
    public function setApplicationId(string $appId): CliAppBuilder
    {
        $this->config->setApplicationId($appId);

        return $this;
    }

    public function setApplicationName(string $appName): CliAppBuilder
    {
        $this->config->setApplicationName($appName);

        return $this;
    }

    public function setApplicationVersion(string $appVersion): CliAppBuilder
    {
        $this->config->setApplicationVersion($appVersion);

        return $this;
    }

    public function enableAutoServiceRegistration(string $namespace, string $resource, ?string $exclude = null): CliAppBuilder
    {
        $this->configurators[] = new AutoServiceRegistrationConfigurator($namespace, $resource, $exclude);

        return $this;
    }

    public function enableConsoleCommandAutoRegistration(): CliAppBuilder
    {
        $this->configurators[] = new ConsoleCommandAutoRegistrationConfigurator();

        return $this;
    }

    public function addConfigurator(ConfiguratorInterface $configurator)
    {
        $this->configurators[] = $configurator;
    }

    public function build(): Application
    {
        $containerBuilder = new ContainerBuilder();

        $this->applyConfigurators($containerBuilder);
        $this->compileContainer($containerBuilder);

        $app = $containerBuilder->get($this->config->getApplicationId());

        $this->reset();

        return $app;
    }

    private function reset()
    {
        $this->config = new CliAppConfig();
        $this->configurators = $this->getDefaultConfigurators();
    }

    protected function compileContainer(ContainerBuilder $containerBuilder)
    {
        $containerBuilder->compile();
    }
    
    protected function applyConfigurators(ContainerBuilder $containerBuilder)
    {
        foreach ($this->configurators as $configurator) {
            $configurator->configure($containerBuilder, $this->config);
        }
    }

    /**
     * @return ConfiguratorInterface[]
     */
    protected function getDefaultConfigurators(): array
    {
        return [new ApplicationServiceConfigurator()];
    }
}
