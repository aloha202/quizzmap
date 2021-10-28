<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211026131236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, name VARCHAR(255) NOT NULL, is_correct TINYINT(1) DEFAULT NULL, INDEX IDX_DADD4A251E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE area (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, boundries LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, area_id INT NOT NULL, type_id INT NOT NULL, sublocations_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, position VARCHAR(50) DEFAULT NULL, INDEX IDX_5E9E89CBBD0F409C (area_id), INDEX IDX_5E9E89CBC54C8C93 (type_id), INDEX IDX_5E9E89CB56339943 (sublocations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, location_type_id INT NOT NULL, name VARCHAR(255) NOT NULL, level INT NOT NULL, INDEX IDX_B6F7494E2B099F37 (location_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBBD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBC54C8C93 FOREIGN KEY (type_id) REFERENCES location_type (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB56339943 FOREIGN KEY (sublocations_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E2B099F37 FOREIGN KEY (location_type_id) REFERENCES location_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBBD0F409C');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB56339943');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBC54C8C93');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E2B099F37');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE area');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE location_type');
        $this->addSql('DROP TABLE question');
    }
}
