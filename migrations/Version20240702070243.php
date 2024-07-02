<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702070243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE ddress_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE address (id INT NOT NULL, address_line TEXT NOT NULL, city TEXT NOT NULL, country TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE ddress');
        $this->addSql('ALTER TABLE pay_methode ADD address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pay_methode ADD CONSTRAINT FK_44DC85F3F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_44DC85F3F5B7AF75 ON pay_methode (address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pay_methode DROP CONSTRAINT FK_44DC85F3F5B7AF75');
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE ddress_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ddress (id INT NOT NULL, address_line TEXT NOT NULL, city TEXT NOT NULL, country TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP INDEX IDX_44DC85F3F5B7AF75');
        $this->addSql('ALTER TABLE pay_methode DROP address_id');
    }
}
