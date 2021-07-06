<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210706080057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE testimony DROP FOREIGN KEY FK_523C9487A76ED395');
        $this->addSql('DROP INDEX UNIQ_523C9487A76ED395 ON testimony');
        $this->addSql('ALTER TABLE testimony ADD users_id INT NOT NULL, DROP user_id');
        $this->addSql('ALTER TABLE testimony ADD CONSTRAINT FK_523C948767B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_523C948767B3B43D ON testimony (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE testimony DROP FOREIGN KEY FK_523C948767B3B43D');
        $this->addSql('DROP INDEX IDX_523C948767B3B43D ON testimony');
        $this->addSql('ALTER TABLE testimony ADD user_id INT DEFAULT NULL, DROP users_id');
        $this->addSql('ALTER TABLE testimony ADD CONSTRAINT FK_523C9487A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_523C9487A76ED395 ON testimony (user_id)');
    }
}
