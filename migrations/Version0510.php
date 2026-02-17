<?php

    declare(strict_types=1);

    namespace DoctrineMigrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    final class Version_0510 extends AbstractMigration
    {
        public function up(Schema $schema): void
        {
            $this->addSql("CREATE TABLE tab_0510 ()");

            $schema->hasTable('tab_0510');
        }
    }
