<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211103124845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location_type ADD parent_location_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE location_type ADD CONSTRAINT FK_CDAE2699F95ED04 FOREIGN KEY (parent_location_type_id) REFERENCES location_type (id)');
        $this->addSql('CREATE INDEX IDX_CDAE2699F95ED04 ON location_type (parent_location_type_id)');
        $this->addSql('ALTER TABLE question CHANGE type type INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location_type DROP FOREIGN KEY FK_CDAE2699F95ED04');
        $this->addSql('DROP INDEX IDX_CDAE2699F95ED04 ON location_type');
        $this->addSql('ALTER TABLE location_type DROP parent_location_type_id');
        $this->addSql('ALTER TABLE question CHANGE type type INT DEFAULT 1 NOT NULL');
    }
}
