<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230908064049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_entity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_type_entity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_entity (id INT AUTO_INCREMENT NOT NULL, payment_type_id INT DEFAULT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start_date DATE NOT NULL, coasts DOUBLE PRECISION DEFAULT NULL, payment_period INT DEFAULT NULL, INDEX IDX_C7DE5CEFDC058279 (payment_type_id), INDEX IDX_C7DE5CEF12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subscription_entity ADD CONSTRAINT FK_C7DE5CEFDC058279 FOREIGN KEY (payment_type_id) REFERENCES payment_type_entity (id)');
        $this->addSql('ALTER TABLE subscription_entity ADD CONSTRAINT FK_C7DE5CEF12469DE2 FOREIGN KEY (category_id) REFERENCES category_entity (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription_entity DROP FOREIGN KEY FK_C7DE5CEFDC058279');
        $this->addSql('ALTER TABLE subscription_entity DROP FOREIGN KEY FK_C7DE5CEF12469DE2');
        $this->addSql('DROP TABLE category_entity');
        $this->addSql('DROP TABLE payment_type_entity');
        $this->addSql('DROP TABLE subscription_entity');
    }
}
