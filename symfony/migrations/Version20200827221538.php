<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200827221538 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, amount INT NOT NULL, currency VARCHAR(3) NOT NULL, id_external_transaction VARCHAR(32) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_status (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_status_log (id INT AUTO_INCREMENT NOT NULL, id_transaction_id INT NOT NULL, id_status_id INT DEFAULT NULL, id_prev_status_id INT DEFAULT NULL, INDEX IDX_64A6B9B212A67609 (id_transaction_id), INDEX IDX_64A6B9B2EBC2BC9A (id_status_id), INDEX IDX_64A6B9B2BF9DF435 (id_prev_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment_status_log ADD CONSTRAINT FK_64A6B9B212A67609 FOREIGN KEY (id_transaction_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE payment_status_log ADD CONSTRAINT FK_64A6B9B2EBC2BC9A FOREIGN KEY (id_status_id) REFERENCES payment_status (id)');
        $this->addSql('ALTER TABLE payment_status_log ADD CONSTRAINT FK_64A6B9B2BF9DF435 FOREIGN KEY (id_prev_status_id) REFERENCES payment_status (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment_status_log DROP FOREIGN KEY FK_64A6B9B212A67609');
        $this->addSql('ALTER TABLE payment_status_log DROP FOREIGN KEY FK_64A6B9B2EBC2BC9A');
        $this->addSql('ALTER TABLE payment_status_log DROP FOREIGN KEY FK_64A6B9B2BF9DF435');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE payment_status');
        $this->addSql('DROP TABLE payment_status_log');
    }
}
