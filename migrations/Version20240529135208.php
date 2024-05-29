<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240529135208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add new data_management_log table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE data_management_log (
                id INT AUTO_INCREMENT NOT NULL,
                filename VARCHAR(255) NOT NULL,
                run_time DATETIME(6) NOT NULL,
                PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE data_management_log');
    }
}
