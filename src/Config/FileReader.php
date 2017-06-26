<?php

declare(strict_types = 1);

namespace Isslocator\Config;

use Isslocator\Exception\ConfigException;

class FileReader implements Reader
{
    /**
     * @var string
     */
    private $configPath = '';

    /**
     * @var array
     */
    private $config = [];

    public function __construct(string $configPath)
    {
        if ($configPath === '') {
            throw new \InvalidArgumentException("Config file path can not be empty");
        }
        $this->configPath = $configPath;
        $this->loadConfig();
    }

    /**
     * @inheritdoc
     */
    public function get(string $param = '')
    {
        return $this->config[$param] ?? null;
    }

    /**
     * Loads config from file
     *
     * @throws ConfigException
     */
    private function loadConfig()
    {
        if (!file_exists($this->configPath) || !is_readable($this->configPath)) {
            throw new ConfigException("Not able to load config from {$this->configPath}");
        }

        $this->config = parse_ini_file($this->configPath);

        if (!is_array($this->config)) {
            throw new ConfigException("Error while parsing config file ({$this->configPath})");
        }
    }
}
