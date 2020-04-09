<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191128090036 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE inscription_formation');
        $this->addSql('DROP TABLE inscription_visiteur');
        $this->addSql('ALTER TABLE formation ADD date_examen DATE NOT NULL');
        $this->addSql('ALTER TABLE inscription CHANGE statut statut VARCHAR(1) NOT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D65200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE inscription_formation (inscription_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_E655E3A75DAC5993 (inscription_id), INDEX IDX_E655E3A75200282E (formation_id), PRIMARY KEY(inscription_id, formation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE inscription_visiteur (inscription_id INT NOT NULL, visiteur_id INT NOT NULL, INDEX IDX_E730F81D5DAC5993 (inscription_id), INDEX IDX_E730F81D7F72333D (visiteur_id), PRIMARY KEY(inscription_id, visiteur_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE inscription_formation ADD CONSTRAINT FK_E655E3A75200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_formation ADD CONSTRAINT FK_E655E3A75DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_visiteur ADD CONSTRAINT FK_E730F81D5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_visiteur ADD CONSTRAINT FK_E730F81D7F72333D FOREIGN KEY (visiteur_id) REFERENCES visiteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation DROP date_examen');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D65200282E');
        $this->addSql('ALTER TABLE inscription CHANGE statut statut VARCHAR(1) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
