<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702124814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE reservation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE reservation (id INT NOT NULL, owner_id INT DEFAULT NULL, payement_id INT DEFAULT NULL, horair_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, price INT NOT NULL, nb_place INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_42C849557E3C61F9 ON reservation (owner_id)');
        $this->addSql('CREATE INDEX IDX_42C84955868C0609 ON reservation (payement_id)');
        $this->addSql('CREATE INDEX IDX_42C849557C32F9F1 ON reservation (horair_id)');
        $this->addSql('COMMENT ON COLUMN reservation.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849557E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955868C0609 FOREIGN KEY (payement_id) REFERENCES pay_methode (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849557C32F9F1 FOREIGN KEY (horair_id) REFERENCES horair (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE reservation_id_seq CASCADE');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C849557E3C61F9');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C84955868C0609');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C849557C32F9F1');
        $this->addSql('DROP TABLE reservation');
    }
}
