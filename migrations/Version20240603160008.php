<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240603160008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Director entity';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            CREATE TABLE director (
                id INT AUTO_INCREMENT NOT NULL,
                title VARCHAR(5) DEFAULT NULL,
                first_name VARCHAR(255) NOT NULL,
                last_name VARCHAR(255) NOT NULL,
                email VARCHAR(255) DEFAULT NULL,
                mobile VARCHAR(13) DEFAULT NULL,
                date_of_birth VARCHAR(10) DEFAULT NULL,
                professional_title VARCHAR(255) DEFAULT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE director');
    }
}
