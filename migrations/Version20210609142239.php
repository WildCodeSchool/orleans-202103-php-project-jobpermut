<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210609142239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registered_user ADD subscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registered_user ADD CONSTRAINT FK_8B903F569A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8B903F569A1887DC ON registered_user (subscription_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registered_user DROP FOREIGN KEY FK_8B903F569A1887DC');
        $this->addSql('DROP INDEX UNIQ_8B903F569A1887DC ON registered_user');
        $this->addSql('ALTER TABLE registered_user DROP subscription_id');
    }
}
