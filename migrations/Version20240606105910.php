<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240606105910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Company Entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE company (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL,
                ident VARCHAR(255) NOT NULL,
                type VARCHAR(255) NOT NULL,
                company_number INT NOT NULL,
                address_id INT DEFAULT NULL,
                UNIQUE INDEX UNIQ_4FBF094FF5B7AF75 (address_id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4
        ');

        $this->addSql('
            ALTER TABLE company ADD CONSTRAINT FK_4FBF094FF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FF5B7AF75');
        $this->addSql('DROP TABLE company');
    }
}
