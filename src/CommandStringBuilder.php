<?php

namespace MysqlToSqlite;

use Illuminate\Contracts\Foundation\Application;

class CommandStringBuilder
{
    /** @var Application */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Build the command string from the configuration
     *
     * @return string
     */
    public function build(ConversionConfig $config, $dumpName)
    {
        $command = [$config->converterExecutable()];
        $command[] = '-h '.$config->host();
        $command[] = '-u '.$config->username();
        $command[] = '-p'.$config->password();
        $command[] = '-P '.$config->port();
        $command[] = $config->database();

        if ($config->hasConfiguredTables()) {
            $command[] = implode(' ', $config->tables());
        }

        // append any additional mysqldump options
        foreach ($config->extraOptions() as $option => $value) {
            // determine if it's an option or a key/value pair
            if (is_numeric($option)) {
                $command[] = $value;
            } else {
                $command[] = $option.'="'.addslashes($value).'"';
            }
        }

        $command[] = '| sqlite3 '.$this->getOutputPath($dumpName);

        return implode(' ', $command);
    }

    /**
     * @param $dumpName
     * @return string
     */
    public function getOutputPath($dumpName)
    {
        return $this->app->basePath().DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.$dumpName.'.sqlite3';
    }
}
