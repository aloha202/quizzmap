<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211104074218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_quizz_take (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, user_id INT NOT NULL, points INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_668D358964D218E (location_id), INDEX IDX_668D3589A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_quizz_take ADD CONSTRAINT FK_668D358964D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE user_quizz_take ADD CONSTRAINT FK_668D3589A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_question_answer ADD user_quizz_take_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_question_answer ADD CONSTRAINT FK_CF5C09A2B99DD872 FOREIGN KEY (user_quizz_take_id) REFERENCES user_quizz_take (id)');
        $this->addSql('CREATE INDEX IDX_CF5C09A2B99DD872 ON user_question_answer (user_quizz_take_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_question_answer DROP FOREIGN KEY FK_CF5C09A2B99DD872');
        $this->addSql('DROP TABLE user_quizz_take');
        $this->addSql('DROP INDEX IDX_CF5C09A2B99DD872 ON user_question_answer');
        $this->addSql('ALTER TABLE user_question_answer DROP user_quizz_take_id');
    }
}
