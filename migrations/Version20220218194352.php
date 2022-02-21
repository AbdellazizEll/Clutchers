<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220218194352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27C09A1CAE');
        $this->addSql('DROP INDEX IDX_29A5EC27C09A1CAE ON produit');
        $this->addSql('ALTER TABLE produit CHANGE id_cat_id cat_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27E6ADA943 FOREIGN KEY (cat_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27E6ADA943 ON produit (cat_id)');
        $this->addSql('ALTER TABLE reclamation DROP ref');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories CHANGE nom_c nom_c VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27E6ADA943');
        $this->addSql('DROP INDEX IDX_29A5EC27E6ADA943 ON produit');
        $this->addSql('ALTER TABLE produit CHANGE nom_p nom_p VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cat_id id_cat_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27C09A1CAE FOREIGN KEY (id_cat_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27C09A1CAE ON produit (id_cat_id)');
        $this->addSql('ALTER TABLE reclamation ADD ref VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sujet sujet VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE content content VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}