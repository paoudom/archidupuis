<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210805145728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carousel ADD chantier_id INT NOT NULL');
        $this->addSql('ALTER TABLE carousel ADD CONSTRAINT FK_1DD74700D0C0049D FOREIGN KEY (chantier_id) REFERENCES chantier (id)');
        $this->addSql('CREATE INDEX IDX_1DD74700D0C0049D ON carousel (chantier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carousel DROP FOREIGN KEY FK_1DD74700D0C0049D');
        $this->addSql('DROP INDEX IDX_1DD74700D0C0049D ON carousel');
        $this->addSql('ALTER TABLE carousel DROP chantier_id');
    }
}
