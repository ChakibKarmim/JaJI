<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329131434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formations_user DROP CONSTRAINT fk_d653fd6a3bf5b0c2');
        $this->addSql('ALTER TABLE formations_user DROP CONSTRAINT fk_d653fd6aa76ed395');
        $this->addSql('DROP TABLE formations_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE formations_user (formations_id UUID NOT NULL, user_id UUID NOT NULL, PRIMARY KEY(formations_id, user_id))');
        $this->addSql('CREATE INDEX idx_d653fd6aa76ed395 ON formations_user (user_id)');
        $this->addSql('CREATE INDEX idx_d653fd6a3bf5b0c2 ON formations_user (formations_id)');
        $this->addSql('COMMENT ON COLUMN formations_user.formations_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN formations_user.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE formations_user ADD CONSTRAINT fk_d653fd6a3bf5b0c2 FOREIGN KEY (formations_id) REFERENCES formations (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formations_user ADD CONSTRAINT fk_d653fd6aa76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
