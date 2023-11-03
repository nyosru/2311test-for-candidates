<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version202311031202312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'заполнение бд инфой о налогах (сидирование)';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("TRUNCATE TABLE `sym23112`.`nalog`");
        $this->addSql("INSERT INTO `nalog` ( `country`, `procent`, `key`, `filter`) VALUES 
            ( 'Германия', '19', 'DE', '{.*}'),
            ( 'Италия', '22', 'IT', '{.*}'),
            ( 'Греция', '24', 'GE', '{.*}'),
            ( 'Франция', '20', 'FR', '{.*}')
            ;");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
//        $this->addSql('DROP TABLE nalog');
//        $this->addSql('ALTER TABLE `order` CHANGE product product INT NOT NULL, CHANGE tax_number tax_number VARCHAR(255) NOT NULL, CHANGE coupon_code coupon_code VARCHAR(255) NOT NULL');
    }
}
