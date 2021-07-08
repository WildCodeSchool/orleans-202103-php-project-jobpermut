<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210707132337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE testimony DROP INDEX UNIQ_523C9487A76ED395, ADD INDEX IDX_523C9487A76ED395 (user_id)');
        $this->addSql('ALTER TABLE user CHANGE is_visible is_visible TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE testimony DROP INDEX IDX_523C9487A76ED395, ADD UNIQUE INDEX UNIQ_523C9487A76ED395 (user_id)');
        $this->addSql('ALTER TABLE user CHANGE is_visible is_visible TINYINT(1) DEFAULT NULL');
    }
}
