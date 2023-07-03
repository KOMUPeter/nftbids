<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230702121624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649906B661A');
        $this->addSql('DROP INDEX UNIQ_8D93D649906B661A ON user');
        $this->addSql('ALTER TABLE user CHANGE lives_id line1_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494EF3765A FOREIGN KEY (line1_id) REFERENCES adresse (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6494EF3765A ON user (line1_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494EF3765A');
        $this->addSql('DROP INDEX UNIQ_8D93D6494EF3765A ON user');
        $this->addSql('ALTER TABLE user CHANGE line1_id lives_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649906B661A FOREIGN KEY (lives_id) REFERENCES adresse (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649906B661A ON user (lives_id)');
    }
}
