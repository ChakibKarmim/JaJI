<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329110138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE career (id UUID NOT NULL, tags TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN career.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN career.tags IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE chapters (id UUID NOT NULL, formation_id_id UUID NOT NULL, title VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C72143719CF0022 ON chapters (formation_id_id)');
        $this->addSql('COMMENT ON COLUMN chapters.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN chapters.formation_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE formations (id UUID NOT NULL, career_id UUID NOT NULL, author_id_id UUID NOT NULL, title VARCHAR(50) NOT NULL, description TEXT NOT NULL, duration INT NOT NULL, difficulty VARCHAR(50) NOT NULL, status VARCHAR(50) DEFAULT NULL, nb_lessons INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_40902137B58CDA09 ON formations (career_id)');
        $this->addSql('CREATE INDEX IDX_4090213769CCBE9A ON formations (author_id_id)');
        $this->addSql('COMMENT ON COLUMN formations.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN formations.career_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN formations.author_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE formations_user (formations_id UUID NOT NULL, user_id UUID NOT NULL, PRIMARY KEY(formations_id, user_id))');
        $this->addSql('CREATE INDEX IDX_D653FD6A3BF5B0C2 ON formations_user (formations_id)');
        $this->addSql('CREATE INDEX IDX_D653FD6AA76ED395 ON formations_user (user_id)');
        $this->addSql('COMMENT ON COLUMN formations_user.formations_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN formations_user.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE lesson (id UUID NOT NULL, chapter_id_id UUID NOT NULL, title VARCHAR(50) NOT NULL, video_url VARCHAR(255) DEFAULT NULL, content TEXT NOT NULL, intro TEXT NOT NULL, duration INT NOT NULL, lesson_order INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F87474F3FF0D08E8 ON lesson (chapter_id_id)');
        $this->addSql('COMMENT ON COLUMN lesson.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN lesson.chapter_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE questions (id UUID NOT NULL, quizz_id_id UUID NOT NULL, title VARCHAR(255) NOT NULL, question VARCHAR(255) NOT NULL, has_multiple_choices BOOLEAN NOT NULL, choices TEXT NOT NULL, answers TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8ADC54D585BD94A9 ON questions (quizz_id_id)');
        $this->addSql('COMMENT ON COLUMN questions.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN questions.quizz_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN questions.choices IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN questions.answers IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE quizz (id UUID NOT NULL, chaptre_id_id UUID NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7C77973D2B0A929A ON quizz (chaptre_id_id)');
        $this->addSql('COMMENT ON COLUMN quizz.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN quizz.chaptre_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, career_id UUID NOT NULL, user_formations_id UUID NOT NULL, firstname VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, lastname VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D649B58CDA09 ON "user" (career_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D57B1D92 ON "user" (user_formations_id)');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "user".career_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "user".user_formations_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE user_lessons (id UUID NOT NULL, lesson_id UUID NOT NULL, user_id_id UUID NOT NULL, is_completed BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_674F06D3CDF80196 ON user_lessons (lesson_id)');
        $this->addSql('CREATE INDEX IDX_674F06D39D86650F ON user_lessons (user_id_id)');
        $this->addSql('COMMENT ON COLUMN user_lessons.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_lessons.lesson_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_lessons.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE user_quizz (id UUID NOT NULL, user_id_id UUID NOT NULL, quizz_id_id UUID NOT NULL, is_passed BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9EB56C659D86650F ON user_quizz (user_id_id)');
        $this->addSql('CREATE INDEX IDX_9EB56C6585BD94A9 ON user_quizz (quizz_id_id)');
        $this->addSql('COMMENT ON COLUMN user_quizz.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_quizz.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_quizz.quizz_id_id IS \'(DC2Type:uuid)\'');
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
        $this->addSql('ALTER TABLE chapters ADD CONSTRAINT FK_C72143719CF0022 FOREIGN KEY (formation_id_id) REFERENCES formations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formations ADD CONSTRAINT FK_40902137B58CDA09 FOREIGN KEY (career_id) REFERENCES career (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formations ADD CONSTRAINT FK_4090213769CCBE9A FOREIGN KEY (author_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formations_user ADD CONSTRAINT FK_D653FD6A3BF5B0C2 FOREIGN KEY (formations_id) REFERENCES formations (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formations_user ADD CONSTRAINT FK_D653FD6AA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3FF0D08E8 FOREIGN KEY (chapter_id_id) REFERENCES chapters (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D585BD94A9 FOREIGN KEY (quizz_id_id) REFERENCES quizz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quizz ADD CONSTRAINT FK_7C77973D2B0A929A FOREIGN KEY (chaptre_id_id) REFERENCES chapters (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649B58CDA09 FOREIGN KEY (career_id) REFERENCES career (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649D57B1D92 FOREIGN KEY (user_formations_id) REFERENCES formations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_lessons ADD CONSTRAINT FK_674F06D3CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_lessons ADD CONSTRAINT FK_674F06D39D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_quizz ADD CONSTRAINT FK_9EB56C659D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_quizz ADD CONSTRAINT FK_9EB56C6585BD94A9 FOREIGN KEY (quizz_id_id) REFERENCES quizz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chapters DROP CONSTRAINT FK_C72143719CF0022');
        $this->addSql('ALTER TABLE formations DROP CONSTRAINT FK_40902137B58CDA09');
        $this->addSql('ALTER TABLE formations DROP CONSTRAINT FK_4090213769CCBE9A');
        $this->addSql('ALTER TABLE formations_user DROP CONSTRAINT FK_D653FD6A3BF5B0C2');
        $this->addSql('ALTER TABLE formations_user DROP CONSTRAINT FK_D653FD6AA76ED395');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F3FF0D08E8');
        $this->addSql('ALTER TABLE questions DROP CONSTRAINT FK_8ADC54D585BD94A9');
        $this->addSql('ALTER TABLE quizz DROP CONSTRAINT FK_7C77973D2B0A929A');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649B58CDA09');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649D57B1D92');
        $this->addSql('ALTER TABLE user_lessons DROP CONSTRAINT FK_674F06D3CDF80196');
        $this->addSql('ALTER TABLE user_lessons DROP CONSTRAINT FK_674F06D39D86650F');
        $this->addSql('ALTER TABLE user_quizz DROP CONSTRAINT FK_9EB56C659D86650F');
        $this->addSql('ALTER TABLE user_quizz DROP CONSTRAINT FK_9EB56C6585BD94A9');
        $this->addSql('DROP TABLE career');
        $this->addSql('DROP TABLE chapters');
        $this->addSql('DROP TABLE formations');
        $this->addSql('DROP TABLE formations_user');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE quizz');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_lessons');
        $this->addSql('DROP TABLE user_quizz');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
