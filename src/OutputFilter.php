<?php

namespace MysqlToSqlite;

class OutputFilter
{
    public function filter($output)
    {
        // bypass insecure password warning
        if (str_contains($output, 'password on the command line')) {
            return null;
        }

        // bypass standard "memory" output... not sure why that's a thing
        if (str_contains($output, 'memory')) {
            return null;
        }

        return $output;
    }
}
