<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328133122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE career (id UUID NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN career.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE chapters (id UUID NOT NULL, title VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN chapters.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE formations (id UUID NOT NULL, title VARCHAR(50) NOT NULL, description TEXT NOT NULL, duration INT NOT NULL, difficulty VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN formations.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE lesson (id UUID NOT NULL, title VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN lesson.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE questions (id UUID NOT NULL, title VARCHAR(255) NOT NULL, question VARCHAR(255) NOT NULL, has_multiple_choices BOOLEAN NOT NULL, choices TEXT NOT NULL, answers TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN questions.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN questions.choices IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN questions.answers IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE quizz (id UUID NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN quizz.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, firstname VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, lastname VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE user_lessons (id UUID NOT NULL, is_completed BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN user_lessons.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE user_quizz (id UUID NOT NULL, result INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN user_quizz.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE career');
        $this->addSql('DROP TABLE chapters');
        $this->addSql('DROP TABLE formations');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE quizz');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_lessons');
        $this->addSql('DROP TABLE user_quizz');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
