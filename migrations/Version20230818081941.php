<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230818081941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, line1 VARCHAR(255) NOT NULL, INDEX IDX_C35F08168BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_nft (category_id INT NOT NULL, nft_id INT NOT NULL, INDEX IDX_FC05EB6612469DE2 (category_id), INDEX IDX_FC05EB66E813668D (nft_id), PRIMARY KEY(category_id, nft_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, city_name VARCHAR(60) NOT NULL, postal_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, nft_image_id INT NOT NULL, path VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C53D045F8197443 (nft_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nft (id INT AUTO_INCREMENT NOT NULL, nft_flow_id INT NOT NULL, nft_owner_id INT DEFAULT NULL, nft_name VARCHAR(60) NOT NULL, nft_creation_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', initial_price INT NOT NULL, is_available TINYINT(1) NOT NULL, quantity INT NOT NULL, actual_price INT NOT NULL, INDEX IDX_D9C7463C774FD933 (nft_flow_id), INDEX IDX_D9C7463C4B8030D7 (nft_owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nft_flow (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date_of_flow DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', eth_value INT NOT NULL, INDEX IDX_11510A9EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, lives_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, gender VARCHAR(50) NOT NULL, date_of_birth DATE NOT NULL, last_name VARCHAR(60) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649906B661A (lives_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F08168BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category_nft ADD CONSTRAINT FK_FC05EB6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_nft ADD CONSTRAINT FK_FC05EB66E813668D FOREIGN KEY (nft_id) REFERENCES nft (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F8197443 FOREIGN KEY (nft_image_id) REFERENCES nft (id)');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463C774FD933 FOREIGN KEY (nft_flow_id) REFERENCES nft_flow (id)');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463C4B8030D7 FOREIGN KEY (nft_owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE nft_flow ADD CONSTRAINT FK_11510A9EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649906B661A FOREIGN KEY (lives_id) REFERENCES adresse (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F08168BAC62AF');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE category_nft DROP FOREIGN KEY FK_FC05EB6612469DE2');
        $this->addSql('ALTER TABLE category_nft DROP FOREIGN KEY FK_FC05EB66E813668D');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F8197443');
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463C774FD933');
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463C4B8030D7');
        $this->addSql('ALTER TABLE nft_flow DROP FOREIGN KEY FK_11510A9EA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649906B661A');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_nft');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE nft');
        $this->addSql('DROP TABLE nft_flow');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
