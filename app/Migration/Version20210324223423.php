<?php

declare(strict_types=1);

namespace App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324223423 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE country (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', name VARCHAR(255) NOT NULL, code_currency VARCHAR(3) NOT NULL, code_continent VARCHAR(2) NOT NULL, code_alpha2 VARCHAR(2) NOT NULL, code_language VARCHAR(2) NOT NULL, UNIQUE INDEX UNIQ_5373C9665E237E06 (name), UNIQUE INDEX UNIQ_5373C966C8E48ED0 (code_alpha2), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currency (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', code VARCHAR(3) NOT NULL, rate DOUBLE PRECISION NOT NULL, symbol_before VARCHAR(3) NOT NULL, symbol_after VARCHAR(3) NOT NULL, decimal_places SMALLINT NOT NULL, decimal_separator VARCHAR(1) NOT NULL, thousands_separator VARCHAR(1) NOT NULL, round_down TINYINT(1) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_6956883F77153098 (code), INDEX search_default (rate), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ip_address (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', country_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', ipv6_address BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', ipv4_address INT UNSIGNED DEFAULT NULL, is_ipv6 TINYINT(1) NOT NULL, domain_host VARCHAR(255) NOT NULL, page_loads INT NOT NULL, INDEX IDX_22FFD58CF92F3E70 (country_id), INDEX search_ipv4_index (ipv4_address), INDEX search_ipv6_index (ipv6_address), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', name VARCHAR(63) NOT NULL, name_original VARCHAR(63) NOT NULL, iso VARCHAR(2) NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_D4DB71B561587F41 (iso), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', ip_address_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', hash VARCHAR(26) NOT NULL, is_crawler TINYINT(1) NOT NULL, crawler_name VARCHAR(63) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D044D5D45F23F921 (ip_address_id), UNIQUE INDEX UNIQ_D044D5D4D1B862B8 (hash), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE snippet (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', forked_from_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', session_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', ip_address_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', syntax_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', title VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL COLLATE `utf8_bin`, encoded_number INT NOT NULL, payload LONGTEXT NOT NULL, views INT NOT NULL, created_at DATETIME NOT NULL, expire_at DATETIME NOT NULL, INDEX IDX_961C8CD5684644A7 (forked_from_id), INDEX IDX_961C8CD5613FECDF (session_id), INDEX IDX_961C8CD55F23F921 (ip_address_id), INDEX IDX_961C8CD544DBD3C6 (syntax_id), INDEX slug (slug), INDEX encoded_number (encoded_number), INDEX created_at (created_at), INDEX expire_at (expire_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE syntax (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_628FBF265E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ip_address ADD CONSTRAINT FK_22FFD58CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D45F23F921 FOREIGN KEY (ip_address_id) REFERENCES ip_address (id)');
        $this->addSql('ALTER TABLE snippet ADD CONSTRAINT FK_961C8CD5684644A7 FOREIGN KEY (forked_from_id) REFERENCES snippet (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE snippet ADD CONSTRAINT FK_961C8CD5613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE snippet ADD CONSTRAINT FK_961C8CD55F23F921 FOREIGN KEY (ip_address_id) REFERENCES ip_address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE snippet ADD CONSTRAINT FK_961C8CD544DBD3C6 FOREIGN KEY (syntax_id) REFERENCES syntax (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ip_address DROP FOREIGN KEY FK_22FFD58CF92F3E70');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D45F23F921');
        $this->addSql('ALTER TABLE snippet DROP FOREIGN KEY FK_961C8CD55F23F921');
        $this->addSql('ALTER TABLE snippet DROP FOREIGN KEY FK_961C8CD5613FECDF');
        $this->addSql('ALTER TABLE snippet DROP FOREIGN KEY FK_961C8CD5684644A7');
        $this->addSql('ALTER TABLE snippet DROP FOREIGN KEY FK_961C8CD544DBD3C6');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE ip_address');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE snippet');
        $this->addSql('DROP TABLE syntax');
    }
}
