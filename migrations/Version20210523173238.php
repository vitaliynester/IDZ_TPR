<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210523173238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE employee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE employee_skills_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE skill_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE skill_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, patronymic VARCHAR(255) DEFAULT NULL, position VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE employee_skills (id INT NOT NULL, employee_id INT NOT NULL, skill_id INT NOT NULL, skill_level INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FC00D2E58C03F15C ON employee_skills (employee_id)');
        $this->addSql('CREATE INDEX IDX_FC00D2E55585C142 ON employee_skills (skill_id)');
        $this->addSql('CREATE TABLE skill (id INT NOT NULL, skill_category_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5E3DE477AC58042E ON skill (skill_category_id)');
        $this->addSql('CREATE TABLE skill_category (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE employee_skills ADD CONSTRAINT FK_FC00D2E58C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee_skills ADD CONSTRAINT FK_FC00D2E55585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477AC58042E FOREIGN KEY (skill_category_id) REFERENCES skill_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE employee_skills DROP CONSTRAINT FK_FC00D2E58C03F15C');
        $this->addSql('ALTER TABLE employee_skills DROP CONSTRAINT FK_FC00D2E55585C142');
        $this->addSql('ALTER TABLE skill DROP CONSTRAINT FK_5E3DE477AC58042E');
        $this->addSql('DROP SEQUENCE employee_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE employee_skills_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE skill_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE skill_category_id_seq CASCADE');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE employee_skills');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_category');
    }
}
