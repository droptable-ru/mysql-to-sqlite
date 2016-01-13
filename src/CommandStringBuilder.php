<?php

namespace MysqlToSqlite;

use Illuminate\Contracts\Foundation\Application;

class CommandStringBuilder
{

    /**
     * Build the command string from the configuration
     *
     * @return string
     */
    public function build(ConversionConfig $config)
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

        $command[] = '| sqlite3 '.$config->outputPath();

        return implode(' ', $command);
    }
}
