<?php

namespace MysqlToSqlite;

use Config;
use Illuminate\Contracts\Config\Repository;

class ConversionConfig
{
    /** array */
    protected $config;

    /** string */
    protected $conversionConfig;

    /** Repository */
    protected $configRepository;

    public function __construct(array $config, Repository $configRepository)
    {
        $this->config = $config;
        $this->configRepository = $configRepository;
    }

    /**
     * The path to the convertable executable
     *
     * @return string
     */
    public function converterExecutable()
    {
        return __DIR__.DIRECTORY_SEPARATOR.'mysql2sqlite.sh';
    }

    /**
     * @return string
     */
    public function defaultConversion()
    {
        return $this->config['defaultConversion'];
    }

    /**
     * @return boolean
     */
    public function debug()
    {
        return $this->config['debug'];
    }

    /**
     * Load a specific conversion config
     *
     * @param $conversion
     */
    public function load($conversion)
    {
        $this->conversionConfig = $this->config['conversions'][$conversion];
    }

    /**
     * @param $connection
     * @return string
     */
    public function host()
    {
        return $this->databaseConnectionConfig()['host'];
    }

    /**
     * @param $connection
     * @return string
     */
    public function port()
    {
        return $this->databaseConnectionConfig()['port'];
    }

    /**
     * @param $connection
     * @return string
     */
    public function database()
    {
        return $this->databaseConnectionConfig()['database'];
    }

    /**
     * @param $connection
     * @return string
     */
    public function username()
    {
        return $this->databaseConnectionConfig()['username'];
    }

    /**
     * @param $connection
     * @return string
     */
    public function password()
    {
        return $this->databaseConnectionConfig()['password'];
    }

    /**
     * Determine if the configuration defined
     * specific tables to dump
     *
     * @return bool
     */
    public function hasConfiguredTables()
    {
        return isset($this->conversionConfig['tables']) && is_array($this->conversionConfig['tables']);
    }

    /**
     * @param $connection
     * @return string
     */
    public function tables()
    {
        if ($this->hasConfiguredTables()) {
            return (array)$this->conversionConfig['tables'];
        }

        return null;
    }

    /**
     * @param $connection
     * @return array
     */
    public function extraOptions()
    {
        if (isset($this->conversionConfig['mysqldumpOptions'])) {
            return (array)$this->conversionConfig['mysqldumpOptions'];
        }

        return [];
    }

    private function databaseConnectionConfig()
    {
        return $this->configRepository->get('database.connections.'.$this->conversionConfig['connection']);
    }
}