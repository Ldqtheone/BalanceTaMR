<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201007080814 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(70) NOT NULL, picture_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_project (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_project_team (team_project_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_F5F763C528B46D59 (team_project_id), INDEX IDX_F5F763C5296CD8AE (team_id), PRIMARY KEY(team_project_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE team_project_team ADD CONSTRAINT FK_F5F763C528B46D59 FOREIGN KEY (team_project_id) REFERENCES team_project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_project_team ADD CONSTRAINT FK_F5F763C5296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team_project_team DROP FOREIGN KEY FK_F5F763C5296CD8AE');
        $this->addSql('ALTER TABLE team_project_team DROP FOREIGN KEY FK_F5F763C528B46D59');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_project');
        $this->addSql('DROP TABLE team_project_team');
    }
}
