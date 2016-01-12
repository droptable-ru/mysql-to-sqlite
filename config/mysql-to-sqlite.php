<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Debug mode
    |--------------------------------------------------------------------------
    |
    | Enables debug mode for this utility enabling the mysqldump command being
    | executed to appear in the console when run
    |
    */
    'debug' => false,

    /*
    |--------------------------------------------------------------------------
    | Default conversion
    |--------------------------------------------------------------------------
    |
    | The default conversion to be run when none is specified
    |
    */
    'defaultConversion' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Conversion configuration
    |--------------------------------------------------------------------------
    |
    | You can add as many "conversion" configurations as you'd like.  The
    | idea is that you might need to get dumps of numerous databases to account
    | for difference scenarios.
    | As an example, a name could be "customerServiceDBForCI" stating "what"
    | and "why".
    |
    */

    'conversions' => [

        // A name for this conversion, anything you'd like
        'default' => [
            // The Laravel database connection to use

            'connection' => 'mysql',
            // Which tables to backup, either "*" or make this
            // an array of table names
            'tables' => '*',

            // Any additional parameters to pass to mysqldump
            'mysqldumpOptions' => [
                '--no-data'
            ]
        ]
    ]
];