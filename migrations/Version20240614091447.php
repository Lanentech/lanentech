<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240614091447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add RepeatCost Entity';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            CREATE TABLE repeat_cost (
                id INT AUTO_INCREMENT NOT NULL,
                description VARCHAR(255) NOT NULL,
                cost INT NOT NULL,
                date DATETIME(6) NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4
        SQL;

        $this->addSql($sql);

        $this->addSql('ALTER TABLE expense CHANGE comments comments TEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE repeat_cost');

        $this->addSql('ALTER TABLE expense CHANGE comments comments LONGTEXT DEFAULT NULL');
    }
}
