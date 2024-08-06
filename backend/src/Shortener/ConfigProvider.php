<?php

namespace Shortener;

class ConfigProvider
{
    public function getConfig(): array
    {
        return [
            $_ENV['POSTGRES_HOST'],
            '5432', // Port
            $_ENV['POSTGRES_DB'],
            $_ENV['POSTGRES_USER'],
            $_ENV['POSTGRES_PASSWORD']
        ];
    }
}