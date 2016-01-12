# Laravel mysql-to-sqlite

This is a Laravel wrapper for [esperlu's mysql2sqlite.sh](https://gist.github.com/esperlu/943776) which converts a mysqldump to an Sqlite 3 compatible file.

* [Usage](#usage)
* [Configuration](#configuration)
* [Installation](#installation)

# Usage

You can run the default configuration

```php
php artisan db:mysql-to-sqlite
```

Running a single, default conversion configuration:

```php
php artisan db:mysql-to-sqlite my-conversion-configuration
```

# Configuration

To publish the config...

**For Laravel**

```php
php artisan vendor:publish --provider="MysqlToSqlite\ServiceProvider"
```

**For Lumen**

```php
cp vendor/realpagelouisville/mysql-to-sqlite/config/mysql-to-sqlite.php config/mysql-to-sqlite.php
```

# Installation

You're probably only using this for development, so we'll use `require-dev`:

```
composer require --dev realpagelouisville/mysql-to-sqlite:~1.0
```
