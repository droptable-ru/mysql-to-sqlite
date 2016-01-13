<?php

namespace spec\MysqlToSqlite;

use Illuminate\Contracts\Foundation\Application;
use MysqlToSqlite\ConversionConfig;
use PhpSpec\ObjectBehavior;

class CommandStringBuilderSpec extends ObjectBehavior
{
    protected $config = null;

    function it_includes_executable_and_auth_and_database_in_command($config)
    {
        $exampleConfig = [
            'executable' => '/path/to/executable',
            'host' => 'myHost',
            'user' => 'myUser',
            'port' => 'myPort',
            'password' => 'myPassword',
            'database' => 'myDatabase',
            'outputPath' => '/path/to/output.sqlite'
        ];
        $config->beADoubleOf(ConversionConfig::class);
        $config->converterExecutable()->willReturn($exampleConfig['executable']);
        $config->host()->willReturn($exampleConfig['host']);
        $config->username()->willReturn($exampleConfig['user']);
        $config->password()->willReturn($exampleConfig['password']);
        $config->port()->willReturn($exampleConfig['port']);
        $config->database()->willReturn($exampleConfig['database']);
        $config->hasConfiguredTables()->willReturn(false);
        $config->extraOptions()->willReturn([]);
        $config->outputPath()->willReturn($exampleConfig['outputPath']);
        $dumpName = uniqid();

        // This also natively asserts that no table names were
        // included in this command
        $exampleCommand = implode(' ', [
                $exampleConfig['executable'],
                '-h '. $exampleConfig['host'],
                '-u '. $exampleConfig['user'],
                '-p'. $exampleConfig['password'],
                '-P '. $exampleConfig['port'],
                $exampleConfig['database']
            ]).' | sqlite3 '.$exampleConfig['outputPath'];

        $this->build($config, $dumpName)->shouldReturn($exampleCommand);
    }

    function it_includes_tables($config)
    {
        $databaseName = uniqid();
        $tables = [
            'myTable1',
            'myTable2'
        ];
        $config->beADoubleOf(ConversionConfig::class);
        $config->converterExecutable()->willReturn('');
        $config->host()->willReturn('');
        $config->username()->willReturn('');
        $config->password()->willReturn('');
        $config->port()->willReturn('');
        $config->database()->willReturn($databaseName);
        $config->hasConfiguredTables()->willReturn(true);
        $config->tables()->willReturn($tables);
        $config->extraOptions()->willReturn([]);
        $config->outputPath()->willReturn('');

        // verify table names are listed between the database
        // and the pipe
        $this->build($config, uniqid())->shouldContain($databaseName.' '.implode(' ', $tables).' | ');
    }

    function it_includes_extra_mysqldump_options($config)
    {
        $databaseName = uniqid();

        // array key option with a defined value
        $definedKey = '--defaults-extra-file';
        $options = [
            '--add-drop-table',
            $definedKey => '/path/to/file.cnf'
        ];
        $config->beADoubleOf(ConversionConfig::class);
        $config->converterExecutable()->willReturn('');
        $config->host()->willReturn('');
        $config->username()->willReturn('');
        $config->password()->willReturn('');
        $config->port()->willReturn('');
        $config->database()->willReturn($databaseName);
        $config->hasConfiguredTables()->willReturn(false);
        $config->extraOptions()->willReturn($options);
        $config->outputPath()->willReturn('');

        // verify table names are listed between the database
        // and the pipe
        $expectedOptions = $options[0].' '.$definedKey.'="'.$options[$definedKey].'"';
        $this->build($config, uniqid())->shouldContain($databaseName.' '.$expectedOptions.' | ');
    }
}
