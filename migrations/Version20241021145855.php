<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241021145855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE img_project (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, position INT DEFAULT NULL, cover TINYINT(1) NOT NULL, INDEX IDX_62DC94066C1197C9 (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE img_project ADD CONSTRAINT FK_62DC94066C1197C9 FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE img_project DROP FOREIGN KEY FK_62DC94066C1197C9');
        $this->addSql('DROP TABLE img_project');
    }
}
