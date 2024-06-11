<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240611144816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Invoice Entity';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            CREATE TABLE invoice (
                id INT AUTO_INCREMENT NOT NULL,
                ident VARCHAR(255) NOT NULL,
                number VARCHAR(255) NOT NULL,
                date DATETIME(6) NOT NULL,
                payment_due_date DATETIME(6) NOT NULL,
                agency_invoice_number VARCHAR(255) DEFAULT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE invoice');
    }
}
