<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240529130954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add name to User';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD name VARCHAR(180) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP name');
    }
}
