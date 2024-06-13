<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240613151536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Expense entity';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            CREATE TABLE expense (
                id INT AUTO_INCREMENT NOT NULL,
                description VARCHAR(255) NOT NULL,
                type VARCHAR(17) NOT NULL,
                cost INT NOT NULL,
                date DATETIME(6) NOT NULL,
                comments LONGTEXT DEFAULT NULL,
                category_id INT DEFAULT NULL,
                INDEX IDX_2D3A8DA612469DE2 (category_id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4
        SQL;

        $this->addSql($sql);

        $sql = <<<SQL
            ALTER TABLE expense
                ADD CONSTRAINT FK_2D3A8DA612469DE2 FOREIGN KEY (category_id) REFERENCES expense_category (id)
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA612469DE2');
        $this->addSql('DROP TABLE expense');
    }
}
