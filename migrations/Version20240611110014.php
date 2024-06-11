<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240611110014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Lanentech Entity';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            CREATE TABLE lanentech (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL,
                company_number INT NOT NULL,
                incorporation_date DATETIME(6) NOT NULL,
                PRIMARY KEY(id)
           ) DEFAULT CHARACTER SET utf8mb4
        SQL;

        $this->addSql($sql);

        $this->addSql('ALTER TABLE director ADD company_id INT DEFAULT NULL');

        $this->addSql('
            ALTER TABLE director
                ADD CONSTRAINT FK_1E90D3F0979B1AD6 FOREIGN KEY (company_id) REFERENCES lanentech (id)
        ');

        $this->addSql('CREATE INDEX IDX_1E90D3F0979B1AD6 ON director (company_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE lanentech');

        $this->addSql('ALTER TABLE director DROP FOREIGN KEY FK_1E90D3F0979B1AD6');

        $this->addSql('DROP INDEX IDX_1E90D3F0979B1AD6 ON director');

        $this->addSql('ALTER TABLE director DROP company_id');
    }
}
