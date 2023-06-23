<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230623142633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_nft (category_id INT NOT NULL, nft_id INT NOT NULL, INDEX IDX_FC05EB6612469DE2 (category_id), INDEX IDX_FC05EB66E813668D (nft_id), PRIMARY KEY(category_id, nft_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_nft ADD CONSTRAINT FK_FC05EB6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_nft ADD CONSTRAINT FK_FC05EB66E813668D FOREIGN KEY (nft_id) REFERENCES nft (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_nft DROP FOREIGN KEY FK_FC05EB6612469DE2');
        $this->addSql('ALTER TABLE category_nft DROP FOREIGN KEY FK_FC05EB66E813668D');
        $this->addSql('DROP TABLE category_nft');
    }
}
