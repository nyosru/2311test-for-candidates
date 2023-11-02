<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231102122755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
//        $this->addSql('CREATE TABLE coupon (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
//        $this->addSql('CREATE TABLE nalog (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, country VARCHAR(255) NOT NULL, procent NUMERIC(3, 0) DEFAULT NULL, "key" VARCHAR(5) NOT NULL, filter VARCHAR(255) NOT NULL)');
//        $this->addSql('CREATE TABLE "order2" (id INTEGER PRIMARY KEY AUTOINCREMENT )');
        $this->addSql('CREATE TABLE `order` (    
    `id` int(11) NOT NULL,
    product INT(11) NOT NULL,
    tax_number VARCHAR(255) NOT NULL,
    coupon_code VARCHAR(255) NOT NULL,
    payment_processor VARCHAR(255) DEFAULT NULL                      )');
        $this->addSql('ALTER TABLE `order` ADD PRIMARY KEY (`id`);');
        $this->addSql('ALTER TABLE `order` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');
//        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
//        $this->addSql('DROP TABLE coupon');
//        $this->addSql('DROP TABLE nalog');
        $this->addSql('DROP TABLE "order"');
//        $this->addSql('DROP TABLE product');
    }
}
