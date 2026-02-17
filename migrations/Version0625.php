<?php

    declare(strict_types=1);

    namespace DoctrineMigrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    final class Version_0625 extends AbstractMigration
    {
        public function up(Schema $schema): void
        {
            $this->addSql("CREATE TABLE tab_0625 ()");

            $schema->hasTable('tab_0625');
        }
    }
