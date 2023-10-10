<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010084036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_2694D7A59E45C554 ON demande');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2694D7A59E45C554 ON demande (prestation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_2694D7A59E45C554 ON demande');
        $this->addSql('CREATE INDEX UNIQ_2694D7A59E45C554 ON demande (prestation_id)');
    }
}
