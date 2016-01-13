# Laravel mysql-to-sqlite

This is a Laravel wrapper for [esperlu's mysql2sqlite.sh](https://gist.github.com/esperlu/943776) which converts a mysqldump to an Sqlite 3 compatible file.

* [Usage](#usage)
* [Configuration](#configuration)
* [Installation](#installation)

[![Latest Stable Version](https://poser.pugx.org/realpagelouisville/mysql-to-sqlite/v/stable.png)](https://packagist.org/packages/realpagelouisville/mysql-to-sqlite) [![Total Downloads](https://poser.pugx.org/realpagelouisville/mysql-to-sqlite/downloads.png)](https://packagist.org/packages/realpagelouisville/mysql-to-sqlite) [![Build Status](https://travis-ci.org/RealpageLouisville/mysql-to-sqlite.svg?branch=master)](https://travis-ci.org/realpagelouisville/mysql-to-sqlite)

# Usage

You can run the default configuration

```
php artisan db:mysql-to-sqlite
```

Running a single, default conversion configuration:

```
php artisan db:mysql-to-sqlite customerServiceDBForCI
```

# Configuration

 * Publish the config...

**For Laravel**

Publish the config...

```
php artisan vendor:publish --provider="MysqlToSqlite\ServiceProvider"
```

Add the following to `app/Providers/AppServiceProvider.php`

```php
public function register()
{
    // Class may not be there if it was loaded as a dev dependency
    if (class_exists('MysqlToSqlite\ServiceProvider')) {
        $this->app->register(MysqlToSqlite\ServiceProvider::class),
    }
}
```

**For Lumen**

Publish the config...

```
cp vendor/realpagelouisville/mysql-to-sqlite/config/mysql-to-sqlite.php config/mysql-to-sqlite.php
```

Add the following to `app/bootstrap/app.php`
 
 ```php
 // Class may not be there if it was loaded as a dev dependency
 if(class_exists('MysqlToSqlite\ServiceProvider')) {
     $app->register(MysqlToSqlite\ServiceProvider::class);
 }
 ```

# Installation

You're probably only using this for development, so we'll use `require-dev`:

```
composer require --dev realpagelouisville/mysql-to-sqlite:~1.*
```
