<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231103135109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE visite_enivronnement (visite_id INT NOT NULL, enivronnement_id INT NOT NULL, INDEX IDX_8D3B1D2EC1C5DC59 (visite_id), INDEX IDX_8D3B1D2E19AA79D4 (enivronnement_id), PRIMARY KEY(visite_id, enivronnement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE visite_enivronnement ADD CONSTRAINT FK_8D3B1D2EC1C5DC59 FOREIGN KEY (visite_id) REFERENCES visite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visite_enivronnement ADD CONSTRAINT FK_8D3B1D2E19AA79D4 FOREIGN KEY (enivronnement_id) REFERENCES enivronnement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visite_enivronnement DROP FOREIGN KEY FK_8D3B1D2EC1C5DC59');
        $this->addSql('ALTER TABLE visite_enivronnement DROP FOREIGN KEY FK_8D3B1D2E19AA79D4');
        $this->addSql('DROP TABLE visite_enivronnement');
    }
}
