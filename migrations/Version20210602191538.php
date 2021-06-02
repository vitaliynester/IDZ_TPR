<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210602191538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill DROP CONSTRAINT fk_5e3de477ac58042e');
        $this->addSql('DROP SEQUENCE skill_category_id_seq CASCADE');
        $this->addSql('DROP TABLE skill_category');
        $this->addSql('DROP INDEX idx_5e3de477ac58042e');
        $this->addSql('ALTER TABLE skill DROP skill_category_id');
        $this->addSql('ALTER TABLE task_skills DROP is_required');
        $this->addSql('DROP INDEX uniq_abbd6a1dfca7608c');
        $this->addSql('CREATE INDEX IDX_ABBD6A1DFCA7608C ON work_task (work_team_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE skill_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE skill_category (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE skill ADD skill_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT fk_5e3de477ac58042e FOREIGN KEY (skill_category_id) REFERENCES skill_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5e3de477ac58042e ON skill (skill_category_id)');
        $this->addSql('ALTER TABLE task_skills ADD is_required BOOLEAN NOT NULL');
        $this->addSql('DROP INDEX IDX_ABBD6A1DFCA7608C');
        $this->addSql('CREATE UNIQUE INDEX uniq_abbd6a1dfca7608c ON work_task (work_team_id)');
    }
}
