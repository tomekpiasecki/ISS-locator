<?php

declare(strict_types = 1);

namespace Isslocator\Config;

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
     * @throws \Exception
     */
    private function loadConfig()
    {
        if (!file_exists($this->configPath) || !is_readable($this->configPath)) {
            throw new \Exception('Not able to load config file');
        }

        $this->config = parse_ini_file($this->configPath);

        if (!is_array($this->config)) {
            throw new \Exception('Errow while parsing config file');
        }
    }
}
