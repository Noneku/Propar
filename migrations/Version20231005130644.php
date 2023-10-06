<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231005130644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('DROP INDEX UNIQ_2694D7A59E45C554 ON demande');
        // $this->addSql('DROP INDEX UNIQ_2694D7A519EB6921 ON demande');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2694D7A59E45C554 ON demande (prestation_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2694D7A519EB6921 ON demande (client_id)');
        // $this->addSql('DROP INDEX IDX_1981A66D80E95E18 ON operation');
        // $this->addSql('DROP INDEX UNIQ_1981A66D1B65292 ON operation');
        $this->addSql('CREATE INDEX IDX_1981A66D80E95E18 ON operation (demande_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1981A66D1B65292 ON operation (employe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_2694D7A59E45C554 ON demande');
        $this->addSql('DROP INDEX UNIQ_2694D7A519EB6921 ON demande');
        $this->addSql('CREATE INDEX UNIQ_2694D7A59E45C554 ON demande (prestation_id)');
        $this->addSql('CREATE INDEX UNIQ_2694D7A519EB6921 ON demande (client_id)');
        $this->addSql('DROP INDEX IDX_1981A66D80E95E18 ON operation');
        $this->addSql('DROP INDEX UNIQ_1981A66D1B65292 ON operation');
        $this->addSql('CREATE UNIQUE INDEX IDX_1981A66D80E95E18 ON operation (demande_id)');
        $this->addSql('CREATE INDEX UNIQ_1981A66D1B65292 ON operation (employe_id)');
    }
}
