<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180704135613 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE figure_comments (id INT AUTO_INCREMENT NOT NULL, figure_id INT NOT NULL, author_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE figure_comments ADD CONSTRAINT FK_5C222B9F5C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id)');
        $this->addSql('ALTER TABLE figure_comments ADD CONSTRAINT FK_5C222B9FF675F31B FOREIGN KEY (author_id) REFERENCES app_users (id)');
        $this->addSql('CREATE INDEX IDX_5C222B9F5C011B5 ON figure_comments (figure_id)');
        $this->addSql('CREATE INDEX IDX_5C222B9FF675F31B ON figure_comments (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE figure_comments DROP FOREIGN KEY FK_5C222B9F5C011B5');
        $this->addSql('ALTER TABLE figure_comments DROP FOREIGN KEY FK_5C222B9FF675F31B');
        $this->addSql('DROP INDEX IDX_5C222B9F5C011B5 ON figure_comments');
        $this->addSql('DROP INDEX IDX_5C222B9FF675F31B ON figure_comments');
        $this->addSql('DROP TABLE figure_comments');
    }
}
