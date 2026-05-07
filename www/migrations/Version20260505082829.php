<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260505082829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE componente (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, coste INT NOT NULL, cantidad INT NOT NULL, descripcion LONGTEXT DEFAULT NULL, tarea_id INT NOT NULL, INDEX IDX_1A9C40AC6D5BDFE1 (tarea_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE componente ADD CONSTRAINT FK_1A9C40AC6D5BDFE1 FOREIGN KEY (tarea_id) REFERENCES tarea (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE componente DROP FOREIGN KEY FK_1A9C40AC6D5BDFE1');
        $this->addSql('DROP TABLE componente');
    }
}
