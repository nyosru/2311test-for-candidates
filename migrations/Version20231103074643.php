<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231103074643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
//        $this->addSql('ALTER TABLE `order` CHANGE product product INT DEFAULT NULL, CHANGE tax_number tax_number VARCHAR(255) DEFAULT NULL, CHANGE coupon_code coupon_code VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
//        $this->addSql('ALTER TABLE `order` CHANGE product product INT NOT NULL, CHANGE tax_number tax_number VARCHAR(255) NOT NULL, CHANGE coupon_code coupon_code VARCHAR(255) NOT NULL');
    }
}