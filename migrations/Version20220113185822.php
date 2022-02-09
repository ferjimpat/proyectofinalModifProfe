<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220113185822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cantidad_platos_pedido CHANGE pedido_id pedido_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cliente ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F41C9B25A76ED395 ON cliente (user_id)');
        $this->addSql('ALTER TABLE comentario CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE direccion CHANGE cliente_id cliente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE municipios CHANGE municipio municipio VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurante ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurante ADD CONSTRAINT FK_5957C275A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5957C275A76ED395 ON restaurante (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY FK_F41C9B25A76ED395');
        $this->addSql('ALTER TABLE restaurante DROP FOREIGN KEY FK_5957C275A76ED395');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE cantidad_platos_pedido CHANGE pedido_id pedido_id INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_F41C9B25A76ED395 ON cliente');
        $this->addSql('ALTER TABLE cliente DROP user_id');
        $this->addSql('ALTER TABLE comentario CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE direccion CHANGE cliente_id cliente_id INT NOT NULL');
        $this->addSql('ALTER TABLE municipios CHANGE municipio municipio VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_5957C275A76ED395 ON restaurante');
        $this->addSql('ALTER TABLE restaurante DROP user_id');
    }
}
