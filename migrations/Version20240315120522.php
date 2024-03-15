<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240315120522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update the User table with timestamp properties';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            ALTER TABLE user
                ADD created_at DATETIME(6) NOT NULL,
                ADD updated_at DATETIME(6) NOT NULL,
                ADD last_logged_in DATETIME(6) DEFAULT NULL;
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP created_at, DROP updated_at, DROP last_logged_in');
    }
}
