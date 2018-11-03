<?php

namespace Tkotosz\CliAppBuilder;

class CliAppConfig
{
    /**
     * @var string
     */
    private $appId = 'UNKNOWN';
    
    /**
     * @var string
     */
    private $appName = 'UNKNOWN';
    
    /**
     * @var string
     */
    private $appVersion = 'UNKNOWN';

    public function setApplicationId(string $appId)
    {
        $this->appId = $appId;
    }

    public function setApplicationName(string $appName)
    {
        $this->appName = $appName;
    }

    public function setApplicationVersion(string $appVersion)
    {
        $this->appVersion = $appVersion;
    }

    public function getApplicationId(): string
    {
        return $this->appId;
    }

    public function getApplicationName(): string
    {
        return $this->appName;
    }

    public function getApplicationVersion(): string
    {
        return $this->appVersion;
    }
}
