<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180630080050 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, team1 VARCHAR(55) NOT NULL, score1 INT DEFAULT NULL, team2 VARCHAR(55) NOT NULL, score2 INT DEFAULT NULL, date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pronostic (id INT AUTO_INCREMENT NOT NULL, idgame_id INT NOT NULL, iduser_id INT NOT NULL, pscore1 INT NOT NULL, pscore2 INT NOT NULL, result INT DEFAULT NULL, INDEX IDX_E64BDCDE3B8B8B6B (idgame_id), INDEX IDX_E64BDCDE786A81FB (iduser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(64) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pronostic ADD CONSTRAINT FK_E64BDCDE3B8B8B6B FOREIGN KEY (idgame_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE pronostic ADD CONSTRAINT FK_E64BDCDE786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pronostic DROP FOREIGN KEY FK_E64BDCDE3B8B8B6B');
        $this->addSql('ALTER TABLE pronostic DROP FOREIGN KEY FK_E64BDCDE786A81FB');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE pronostic');
        $this->addSql('DROP TABLE user');
    }
}
