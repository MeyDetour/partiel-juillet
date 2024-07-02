<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702111644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horair ADD version_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE horair ADD date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE horair ADD CONSTRAINT FK_CC10C5F64BBC2705 FOREIGN KEY (version_id) REFERENCES voice_categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CC10C5F64BBC2705 ON horair (version_id)');
        $this->addSql('ALTER TABLE pay_methode ADD expiration TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pay_methode DROP expiration');
        $this->addSql('ALTER TABLE horair DROP CONSTRAINT FK_CC10C5F64BBC2705');
        $this->addSql('DROP INDEX IDX_CC10C5F64BBC2705');
        $this->addSql('ALTER TABLE horair DROP version_id');
        $this->addSql('ALTER TABLE horair DROP date');
    }
}
