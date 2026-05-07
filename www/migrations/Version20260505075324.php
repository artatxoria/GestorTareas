<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260505075324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tarea (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, descripcion LONGTEXT DEFAULT NULL, estado VARCHAR(255) NOT NULL, fecha_limite DATETIME NOT NULL, prioridad INT NOT NULL, propietario_id INT NOT NULL, INDEX IDX_3CA0536653C8D32C (propietario_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, apellido VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, telefono VARCHAR(20) NOT NULL, ciudad VARCHAR(100) NOT NULL, comunidad VARCHAR(100) NOT NULL, dni VARCHAR(10) NOT NULL, genero VARCHAR(10) NOT NULL, fotografia VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tarea ADD CONSTRAINT FK_3CA0536653C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tarea DROP FOREIGN KEY FK_3CA0536653C8D32C');
        $this->addSql('DROP TABLE tarea');
        $this->addSql('DROP TABLE usuario');
    }
}
