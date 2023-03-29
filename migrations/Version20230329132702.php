<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329132702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_formation ADD formation_id_id UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN user_formation.formation_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user_formation ADD CONSTRAINT FK_40A0AC5B9CF0022 FOREIGN KEY (formation_id_id) REFERENCES formations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_40A0AC5B9CF0022 ON user_formation (formation_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_formation DROP CONSTRAINT FK_40A0AC5B9CF0022');
        $this->addSql('DROP INDEX IDX_40A0AC5B9CF0022');
        $this->addSql('ALTER TABLE user_formation DROP formation_id_id');
    }
}
