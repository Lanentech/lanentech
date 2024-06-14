<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240614105757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Billable Entity';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            CREATE TABLE billable (
                id INT AUTO_INCREMENT NOT NULL,
                date DATETIME(6) NOT NULL,
                type VARCHAR(8) NOT NULL,
                rate INT NOT NULL,
                subject_to_vat TINYINT(1) NOT NULL,
                client_id INT DEFAULT NULL,
                invoice_id INT DEFAULT NULL,
                agency_id INT DEFAULT NULL,
                INDEX IDX_F66F1AA019EB6921 (client_id),
                INDEX IDX_F66F1AA02989F1FD (invoice_id),
                INDEX IDX_F66F1AA0CDEADB2A (agency_id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4
        SQL;

        $this->addSql($sql);

        $sql = <<<SQL
            ALTER TABLE billable ADD CONSTRAINT FK_F66F1AA019EB6921 FOREIGN KEY (client_id) REFERENCES company (id)
        SQL;

        $this->addSql($sql);

        $sql = <<<SQL
            ALTER TABLE billable ADD CONSTRAINT FK_F66F1AA02989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)
        SQL;

        $this->addSql($sql);

        $sql = <<<SQL
            ALTER TABLE billable ADD CONSTRAINT FK_F66F1AA0CDEADB2A FOREIGN KEY (agency_id) REFERENCES company (id)
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE billable DROP FOREIGN KEY FK_F66F1AA019EB6921');
        $this->addSql('ALTER TABLE billable DROP FOREIGN KEY FK_F66F1AA02989F1FD');
        $this->addSql('ALTER TABLE billable DROP FOREIGN KEY FK_F66F1AA0CDEADB2A');
        $this->addSql('DROP TABLE billable');
    }
}
