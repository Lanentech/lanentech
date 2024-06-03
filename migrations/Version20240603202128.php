<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240603202128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Address entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE address (
                id INT AUTO_INCREMENT NOT NULL,
                house_name VARCHAR(50) DEFAULT NULL,
                house_number VARCHAR(10) NOT NULL,
                street VARCHAR(75) NOT NULL,
                town_city VARCHAR(75) NOT NULL,
                postcode VARCHAR(7) NOT NULL,
                country VARCHAR(3) NOT NULL,
                PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
            ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE address');
    }
}
