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

        $this->addSql('ALTER TABLE figure_comments ADD author_id INT NOT NULL, DROP user_id, CHANGE content content LONGTEXT NOT NULL, CHANGE figure_id figure_id INT NOT NULL');
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
        $this->addSql('ALTER TABLE figure_comments ADD user_id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP author_id, CHANGE figure_id figure_id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE content content VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
