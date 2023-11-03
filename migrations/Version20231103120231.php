<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231103120231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nalog (id INT AUTO_INCREMENT NOT NULL, country VARCHAR(255) NOT NULL, procent NUMERIC(3, 0) DEFAULT NULL, `key` VARCHAR(5) NOT NULL, filter VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` CHANGE product product INT DEFAULT NULL, CHANGE tax_number tax_number VARCHAR(255) DEFAULT NULL, CHANGE coupon_code coupon_code VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE nalog');
        $this->addSql('ALTER TABLE `order` CHANGE product product INT NOT NULL, CHANGE tax_number tax_number VARCHAR(255) NOT NULL, CHANGE coupon_code coupon_code VARCHAR(255) NOT NULL');
    }
}
