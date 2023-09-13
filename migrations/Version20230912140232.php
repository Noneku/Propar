<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230912140232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demandes (id INT AUTO_INCREMENT NOT NULL, prestation_id INT NOT NULL, client_id INT NOT NULL, date_demande DATETIME NOT NULL, UNIQUE INDEX UNIQ_BD940CBB9E45C554 (prestation_id), UNIQUE INDEX UNIQ_BD940CBB19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employes (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, matricule VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operations (id INT AUTO_INCREMENT NOT NULL, demandes_id INT NOT NULL, employe_id INT NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_28145348F49DCC2D (demandes_id), UNIQUE INDEX UNIQ_281453481B65292 (employe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestations (id INT AUTO_INCREMENT NOT NULL, prix DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demandes ADD CONSTRAINT FK_BD940CBB9E45C554 FOREIGN KEY (prestation_id) REFERENCES prestations (id)');
        $this->addSql('ALTER TABLE demandes ADD CONSTRAINT FK_BD940CBB19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE operations ADD CONSTRAINT FK_28145348F49DCC2D FOREIGN KEY (demandes_id) REFERENCES demandes (id)');
        $this->addSql('ALTER TABLE operations ADD CONSTRAINT FK_281453481B65292 FOREIGN KEY (employe_id) REFERENCES employes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demandes DROP FOREIGN KEY FK_BD940CBB9E45C554');
        $this->addSql('ALTER TABLE demandes DROP FOREIGN KEY FK_BD940CBB19EB6921');
        $this->addSql('ALTER TABLE operations DROP FOREIGN KEY FK_28145348F49DCC2D');
        $this->addSql('ALTER TABLE operations DROP FOREIGN KEY FK_281453481B65292');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE demandes');
        $this->addSql('DROP TABLE employes');
        $this->addSql('DROP TABLE operations');
        $this->addSql('DROP TABLE prestations');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
