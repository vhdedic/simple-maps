<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221101085745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE name_map (id INT AUTO_INCREMENT NOT NULL, name_id INT NOT NULL, map_id INT NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_97B8A25571179CD6 (name_id), INDEX IDX_97B8A25553C55F64 (map_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE name_map ADD CONSTRAINT FK_97B8A25571179CD6 FOREIGN KEY (name_id) REFERENCES name (id)');
        $this->addSql('ALTER TABLE name_map ADD CONSTRAINT FK_97B8A25553C55F64 FOREIGN KEY (map_id) REFERENCES map (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE name_map DROP FOREIGN KEY FK_97B8A25571179CD6');
        $this->addSql('ALTER TABLE name_map DROP FOREIGN KEY FK_97B8A25553C55F64');
        $this->addSql('DROP TABLE name_map');
    }
}
