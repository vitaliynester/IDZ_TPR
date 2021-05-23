<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210523180744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE task_skills_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE work_object_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE work_task_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE work_team_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE task_skills (id INT NOT NULL, work_task_id INT NOT NULL, skill_id INT NOT NULL, skill_level INT NOT NULL, is_required BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EE9892A3587DB9A4 ON task_skills (work_task_id)');
        $this->addSql('CREATE INDEX IDX_EE9892A35585C142 ON task_skills (skill_id)');
        $this->addSql('CREATE TABLE work_object (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE work_task (id INT NOT NULL, work_object_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, priority INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ABBD6A1D4125FE7E ON work_task (work_object_id)');
        $this->addSql('CREATE TABLE work_team (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE task_skills ADD CONSTRAINT FK_EE9892A3587DB9A4 FOREIGN KEY (work_task_id) REFERENCES work_task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_skills ADD CONSTRAINT FK_EE9892A35585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE work_task ADD CONSTRAINT FK_ABBD6A1D4125FE7E FOREIGN KEY (work_object_id) REFERENCES work_object (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee ADD work_team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1FCA7608C FOREIGN KEY (work_team_id) REFERENCES work_team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5D9F75A1FCA7608C ON employee (work_team_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE work_task DROP CONSTRAINT FK_ABBD6A1D4125FE7E');
        $this->addSql('ALTER TABLE task_skills DROP CONSTRAINT FK_EE9892A3587DB9A4');
        $this->addSql('ALTER TABLE employee DROP CONSTRAINT FK_5D9F75A1FCA7608C');
        $this->addSql('DROP SEQUENCE task_skills_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE work_object_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE work_task_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE work_team_id_seq CASCADE');
        $this->addSql('DROP TABLE task_skills');
        $this->addSql('DROP TABLE work_object');
        $this->addSql('DROP TABLE work_task');
        $this->addSql('DROP TABLE work_team');
        $this->addSql('DROP INDEX IDX_5D9F75A1FCA7608C');
        $this->addSql('ALTER TABLE employee DROP work_team_id');
    }
}
