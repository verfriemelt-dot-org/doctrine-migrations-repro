# reproducer

works fine:

```shell
$ php -d opcache.jit=off bin/console doc:mi:mi -vv --no-interaction
```

fails
```shell
$ php -d opcache.jit=on bin/console doc:mi:mi -vv --no-interaction
[notice] Migrating up to DoctrineMigrations\Version_1000
[info] ++ migrating DoctrineMigrations\Version_0001
[debug] CREATE TABLE tab_0001 ()
[info] Migration DoctrineMigrations\Version_0001 migrated (took 22.3ms, used 10M memory)
[info] ++ migrating DoctrineMigrations\Version_0002
```

this hangs forever with 100% cpu usage.

in a private project, i got the slightly different behaviour:

a check like

```php
public function up(Schema $schema): void
    {
        if ($schema->getTable('voucher_redemption')->hasForeignKey('voucher_redemption_FK_2')) {
```

fails even though that table was created beforehand and is present.

```
mysql -e "show tables like 'customer_anonymisation_request'"
+----------------------------------------------------+
| Tables_in_tickeos (customer_anonymisation_request) |
+----------------------------------------------------+
| customer_anonymisation_request                     |
+----------------------------------------------------+
```

the checked table and error'd table are unrelated:

```
In TableDoesNotExist.php line 16:

  [Doctrine\DBAL\Schema\Exception\TableDoesNotExist]
  There is no table with name "customer_anonymisation_request" in the schema.


Exception trace:
  at ./core/vendor/doctrine/dbal/src/Schema/Exception/TableDoesNotExist.php:16
 Doctrine\DBAL\Schema\Exception\TableDoesNotExist::new() at ./core/vendor/doctrine/dbal/src/Schema/Schema.php:226
 Doctrine\DBAL\Schema\Schema->getTable() at ./core/vendor/doctrine/dbal/src/Schema/Comparator.php:64
 Doctrine\DBAL\Schema\Comparator->compareSchemas() at ./core/vendor/doctrine/migrations/src/Provider/DBALSchemaDiffProvider.php:53
 Doctrine\Migrations\Provider\DBALSchemaDiffProvider->getSqlDiffToMigrate() at ./core/vendor/doctrine/migrations/src/Provider/LazySchemaDiffProvider.php:90
 Doctrine\Migrations\Provider\LazySchemaDiffProvider->getSqlDiffToMigrate() at ./core/vendor/doctrine/migrations/src/Version/DbalExecutor.php:144
 Doctrine\Migrations\Version\DbalExecutor->executeMigration() at ./core/vendor/doctrine/migrations/src/Version/DbalExecutor.php:72
 Doctrine\Migrations\Version\DbalExecutor->execute() at ./core/vendor/doctrine/migrations/src/DbalMigrator.php:87
 Doctrine\Migrations\DbalMigrator->executePlan() at ./core/vendor/doctrine/migrations/src/DbalMigrator.php:54
 Doctrine\Migrations\DbalMigrator->executeMigrations() at ./core/vendor/doctrine/migrations/src/DbalMigrator.php:134
 Doctrine\Migrations\DbalMigrator->migrate() at ./core/vendor/doctrine/migrations/src/Tools/Console/Command/MigrateCommand.php:225
 Doctrine\Migrations\Tools\Console\Command\MigrateCommand->execute() at ./core/vendor/symfony/console/Command/Command.php:291
 Symfony\Component\Console\Command\Command->run() at ./core/vendor/symfony/console/Application.php:1092
 Symfony\Component\Console\Application->doRunCommand() at ./core/vendor/symfony/framework-bundle/Console/Application.php:123
 Symfony\Bundle\FrameworkBundle\Console\Application->doRunCommand() at ./core/vendor/symfony/console/Application.php:356
 Symfony\Component\Console\Application->doRun() at ./core/vendor/symfony/framework-bundle/Console/Application.php:77
 Symfony\Bundle\FrameworkBundle\Console\Application->doRun() at ./core/vendor/symfony/console/Application.php:195
 Symfony\Component\Console\Application->run() at ./core/bin/console:100
```

here is my config:


```
$ php --version
PHP 8.5.3 (cli) (built: Feb 13 2026 15:50:47) (NTS)
Copyright (c) The PHP Group
Built by Debian
Zend Engine v4.5.3, Copyright (c) Zend Technologies
    with Xdebug v3.5.0, Copyright (c) 2002-2025, by Derick Rethans
    with Zend OPcache v8.5.3, Copyright (c), by Zend Technologies
    
$ php --ini=diff
Non-default INI settings:
apc.enable_cli: "0" -> "1"
cli.prompt: "\b \> " -> "> "
error_reporting: (none) -> "-1"
html_errors: "1" -> "0"
implicit_flush: "0" -> "1"
max_execution_time: "30" -> "0"
memory_limit: "128M" -> "-1"
opcache.enable_cli: "0" -> "1"
opcache.interned_strings_buffer: "8" -> "128"
opcache.jit: "disable" -> "1"
opcache.jit_buffer_size: "64M" -> "256M"
opcache.max_accelerated_files: "10000" -> "100000"
opcache.memory_consumption: "128" -> "256"
xdebug.mode: "develop" -> ""
xdebug.start_with_request: "default" -> "1"
```
