<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329192353 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, abrev VARCHAR(5) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_64C19C15E237E06 (name), UNIQUE INDEX UNIQ_64C19C15C661BD (abrev), INDEX category_name (name), INDEX category_abrev (abrev), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE indicated (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX indicated_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_indicated (indicated_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_186F12587BC095A8 (indicated_id), INDEX IDX_186F125812469DE2 (category_id), PRIMARY KEY(indicated_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, indicated_id INT NOT NULL, rating INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_5A10856412469DE2 (category_id), INDEX IDX_5A1085647BC095A8 (indicated_id), INDEX vote_rating (rating), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_indicated ADD CONSTRAINT FK_186F12587BC095A8 FOREIGN KEY (indicated_id) REFERENCES indicated (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_indicated ADD CONSTRAINT FK_186F125812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085647BC095A8 FOREIGN KEY (indicated_id) REFERENCES indicated (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_indicated DROP FOREIGN KEY FK_186F125812469DE2');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856412469DE2');
        $this->addSql('ALTER TABLE category_indicated DROP FOREIGN KEY FK_186F12587BC095A8');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085647BC095A8');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE indicated');
        $this->addSql('DROP TABLE category_indicated');
        $this->addSql('DROP TABLE vote');
    }
}
