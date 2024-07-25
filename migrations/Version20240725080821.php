<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240725080821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD claimed_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F67E7A38 FOREIGN KEY (claimed_by_id) REFERENCES yard (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649F67E7A38 ON user (claimed_by_id)');
        $this->addSql('ALTER TABLE yard ADD creation_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', ADD edition_date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE yard DROP creation_date, DROP edition_date');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F67E7A38');
        $this->addSql('DROP INDEX IDX_8D93D649F67E7A38 ON user');
        $this->addSql('ALTER TABLE user DROP claimed_by_id');
    }
}
