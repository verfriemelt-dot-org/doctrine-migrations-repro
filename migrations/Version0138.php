<?php

    declare(strict_types=1);

    namespace DoctrineMigrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    final class Version_0138 extends AbstractMigration
    {
        public function up(Schema $schema): void
        {
            $this->addSql("CREATE TABLE tab_0138 ()");

            $schema->hasTable('tab_0138');
        }
    }
