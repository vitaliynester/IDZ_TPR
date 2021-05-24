<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210523182124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE work_task ADD work_team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE work_task ADD CONSTRAINT FK_ABBD6A1DFCA7608C FOREIGN KEY (work_team_id) REFERENCES work_team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ABBD6A1DFCA7608C ON work_task (work_team_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE work_task DROP CONSTRAINT FK_ABBD6A1DFCA7608C');
        $this->addSql('DROP INDEX UNIQ_ABBD6A1DFCA7608C');
        $this->addSql('ALTER TABLE work_task DROP work_team_id');
    }
}
