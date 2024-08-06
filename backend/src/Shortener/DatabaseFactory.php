<?php

namespace Shortener;

class DatabaseFactory
{
    private array $config;

    public function __construct()
    {
        $config = new ConfigProvider();
        $this->config = $config->getConfig();
    }

    public function create(): Database
    {
        return Database::getInstance(
            $this->config[0],
            $this->config[1],
            $this->config[2],
            $this->config[3],
            $this->config[4]
        );
    }
}