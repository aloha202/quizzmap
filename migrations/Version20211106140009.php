<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211106140009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location ADD min_points INT DEFAULT NULL, ADD min_rating INT DEFAULT NULL, ADD difficulty_from INT DEFAULT NULL, ADD difficulty_to INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD rating DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP min_points, DROP min_rating, DROP difficulty_from, DROP difficulty_to');
        $this->addSql('ALTER TABLE user DROP rating');
    }
}
