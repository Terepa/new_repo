<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230821164502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_promotion DROP FOREIGN KEY FK_AFBDCB5C4584665A');
        $this->addSql('ALTER TABLE product_promotion DROP FOREIGN KEY FK_AFBDCB5C139DF194');
        $this->addSql('DROP TABLE product_promotion');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP INDEX uuid_unique_idx ON product');
        $this->addSql('ALTER TABLE product CHANGE uuid uuid VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_promotion (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, promotion_id INT NOT NULL, valid_to DATETIME DEFAULT NULL, INDEX IDX_AFBDCB5C139DF194 (promotion_id), INDEX IDX_AFBDCB5C4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, adjustment DOUBLE PRECISION NOT NULL, criteria JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_promotion ADD CONSTRAINT FK_AFBDCB5C4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE product_promotion ADD CONSTRAINT FK_AFBDCB5C139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE product CHANGE uuid uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX uuid_unique_idx ON product (uuid)');
    }
}
