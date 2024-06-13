<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240612083651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Expense Category entity';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            CREATE TABLE expense_category (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL,
                description LONGTEXT NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE expense_category');
    }
}
