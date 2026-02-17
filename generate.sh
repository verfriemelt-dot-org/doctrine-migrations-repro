#!/usr/bin/env bash

for i in $(seq 1 1000); do

    i=$(printf '%04d' $i)

    cat > migrations/Version$i.php <<PHP
<?php

    declare(strict_types=1);

    namespace DoctrineMigrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    final class Version_$i extends AbstractMigration
    {
        public function up(Schema \$schema): void
        {
            \$this->addSql("CREATE TABLE tab_$i ()");

            \$schema->hasTable('tab_$i');
        }
    }
PHP
done
