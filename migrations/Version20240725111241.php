<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240725111241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497096A49F');
        $this->addSql('DROP INDEX IDX_8D93D6497096A49F ON user');
        $this->addSql('ALTER TABLE user DROP claim_id');
        $this->addSql('ALTER TABLE yard ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE yard ADD CONSTRAINT FK_29B02F28A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_29B02F28A76ED395 ON yard (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE yard DROP FOREIGN KEY FK_29B02F28A76ED395');
        $this->addSql('DROP INDEX IDX_29B02F28A76ED395 ON yard');
        $this->addSql('ALTER TABLE yard DROP user_id');
        $this->addSql('ALTER TABLE user ADD claim_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497096A49F FOREIGN KEY (claim_id) REFERENCES yard (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D6497096A49F ON user (claim_id)');
    }
}
