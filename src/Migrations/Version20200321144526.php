<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200321144526 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reporte (id INT AUTO_INCREMENT NOT NULL, evento_id INT NOT NULL, descripcion LONGTEXT NOT NULL, INDEX IDX_5CB121487A5F842 (evento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, alias VARCHAR(30) NOT NULL, nombre VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, passwd VARCHAR(255) NOT NULL, fecha_nacimiento DATE NOT NULL, descripcion LONGTEXT DEFAULT NULL, fecha_registro DATETIME NOT NULL, rol TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evento (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, categoria_id INT NOT NULL, titulo VARCHAR(100) NOT NULL, fecha_inicio DATE NOT NULL, fecha_fin DATE DEFAULT NULL, hora TIME NOT NULL, ubicacion VARCHAR(255) NOT NULL, coordenadas VARCHAR(255) NOT NULL, precio INT NOT NULL, descripcion LONGTEXT NOT NULL, imagen VARCHAR(255) DEFAULT NULL, web VARCHAR(255) DEFAULT NULL, visible TINYINT(1) NOT NULL, bloqueado TINYINT(1) NOT NULL, mensaje_moderacion LONGTEXT DEFAULT NULL, INDEX IDX_47860B05DB38439E (usuario_id), INDEX IDX_47860B053397707A (categoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suscripcion (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, evento_id INT NOT NULL, INDEX IDX_497FA0DB38439E (usuario_id), INDEX IDX_497FA087A5F842 (evento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reporte ADD CONSTRAINT FK_5CB121487A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id)');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B05DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B053397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE suscripcion ADD CONSTRAINT FK_497FA0DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE suscripcion ADD CONSTRAINT FK_497FA087A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evento DROP FOREIGN KEY FK_47860B05DB38439E');
        $this->addSql('ALTER TABLE suscripcion DROP FOREIGN KEY FK_497FA0DB38439E');
        $this->addSql('ALTER TABLE evento DROP FOREIGN KEY FK_47860B053397707A');
        $this->addSql('ALTER TABLE reporte DROP FOREIGN KEY FK_5CB121487A5F842');
        $this->addSql('ALTER TABLE suscripcion DROP FOREIGN KEY FK_497FA087A5F842');
        $this->addSql('DROP TABLE reporte');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE evento');
        $this->addSql('DROP TABLE suscripcion');
    }
}
