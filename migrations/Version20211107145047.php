<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211107145047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE submap (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, mapsize VARCHAR(10) DEFAULT NULL, UNIQUE INDEX UNIQ_F085FD5264D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE submap ADD CONSTRAINT FK_F085FD5264D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE location ADD parent_map_id INT DEFAULT NULL, DROP mapsize');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB1CD69CA2 FOREIGN KEY (parent_map_id) REFERENCES submap (id)');
        $this->addSql('CREATE INDEX IDX_5E9E89CB1CD69CA2 ON location (parent_map_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB1CD69CA2');
        $this->addSql('DROP TABLE submap');
        $this->addSql('DROP INDEX IDX_5E9E89CB1CD69CA2 ON location');
        $this->addSql('ALTER TABLE location ADD mapsize VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP parent_map_id');
    }
}
