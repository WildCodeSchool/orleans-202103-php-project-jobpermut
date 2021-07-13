<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210712140005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE match_by_like (id INT AUTO_INCREMENT NOT NULL, user_liker_id INT NOT NULL, user_liked_id INT NOT NULL, matched_at DATETIME NOT NULL, INDEX IDX_EDAA46617712F43A (user_liker_id), INDEX IDX_EDAA4661260FC79 (user_liked_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE match_by_like ADD CONSTRAINT FK_EDAA46617712F43A FOREIGN KEY (user_liker_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE match_by_like ADD CONSTRAINT FK_EDAA4661260FC79 FOREIGN KEY (user_liked_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE match_by_like');
    }
}
