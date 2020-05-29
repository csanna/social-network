<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200529120158 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCED766068');
        $this->addSql('DROP INDEX IDX_67F068BCED766068 ON commentaire');
        $this->addSql('ALTER TABLE commentaire ADD username VARCHAR(255) NOT NULL, DROP username_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commentaire ADD username_id INT DEFAULT NULL, DROP username');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCED766068 FOREIGN KEY (username_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCED766068 ON commentaire (username_id)');
    }
}
