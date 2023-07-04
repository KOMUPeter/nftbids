<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704075125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F92B58A10');
        $this->addSql('DROP INDEX IDX_C53D045F92B58A10 ON image');
        $this->addSql('ALTER TABLE image ADD size INT NOT NULL, ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP image_name, CHANGE contain_id nft_image_id INT NOT NULL, CHANGE image_link path VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F8197443 FOREIGN KEY (nft_image_id) REFERENCES nft (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F8197443 ON image (nft_image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F8197443');
        $this->addSql('DROP INDEX IDX_C53D045F8197443 ON image');
        $this->addSql('ALTER TABLE image ADD contain_id INT NOT NULL, ADD image_name VARCHAR(60) NOT NULL, DROP nft_image_id, DROP size, DROP updated_at, CHANGE path image_link VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F92B58A10 FOREIGN KEY (contain_id) REFERENCES nft (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C53D045F92B58A10 ON image (contain_id)');
    }
}
