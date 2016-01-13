<?php

namespace MysqlToSqlite;

use Config;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

class ConversionConfig
{
    /** array */
    protected $config;

    /** string */
    protected $conversionConfig;

    /** Repository */
    protected $configRepository;

    /** Application */
    protected $app;

    public function __construct(array $config, Repository $configRepository, Application $app)
    {
        $this->config = $config;
        $this->configRepository = $configRepository;
        $this->app = $app;
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
     * @return string
     */
    public function host()
    {
        return $this->databaseConnectionConfig()['host'];
    }

    /**
     * @return string
     */
    public function port()
    {
        return $this->databaseConnectionConfig()['port'];
    }

    /**
     * @return string
     */
    public function database()
    {
        return $this->databaseConnectionConfig()['database'];
    }

    /**
     * @return string
     */
    public function username()
    {
        return $this->databaseConnectionConfig()['username'];
    }

    /**
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
     * @return string
     */
    public function outputPath()
    {
        return
            $this->app->basePath().DIRECTORY_SEPARATOR.
            trim($this->conversionConfig['outputPath'], DIRECTORY_SEPARATOR);
    }

    /**
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
