<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180722102642 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_2F57B37A5E237E06 ON app_figures');
        $this->addSql('ALTER TABLE app_figures ADD featured_image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE app_figures RENAME INDEX uniq_2f57b37a989d9b62 TO UNIQ_46AC80D7989D9B62');
        $this->addSql('ALTER TABLE app_figures_categories RENAME INDEX idx_5f0a4745c011b5 TO IDX_74BBF8BB5C011B5');
        $this->addSql('ALTER TABLE app_figures_categories RENAME INDEX idx_5f0a47412469de2 TO IDX_74BBF8BB12469DE2');
        $this->addSql('ALTER TABLE app_comments RENAME INDEX idx_5c222b9f5c011b5 TO IDX_571EF6875C011B5');
        $this->addSql('ALTER TABLE app_comments RENAME INDEX idx_5c222b9ff675f31b TO IDX_571EF687F675F31B');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_comments RENAME INDEX idx_571ef6875c011b5 TO IDX_5C222B9F5C011B5');
        $this->addSql('ALTER TABLE app_comments RENAME INDEX idx_571ef687f675f31b TO IDX_5C222B9FF675F31B');
        $this->addSql('ALTER TABLE app_figures DROP featured_image');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F57B37A5E237E06 ON app_figures (name)');
        $this->addSql('ALTER TABLE app_figures RENAME INDEX uniq_46ac80d7989d9b62 TO UNIQ_2F57B37A989D9B62');
        $this->addSql('ALTER TABLE app_figures_categories RENAME INDEX idx_74bbf8bb5c011b5 TO IDX_5F0A4745C011B5');
        $this->addSql('ALTER TABLE app_figures_categories RENAME INDEX idx_74bbf8bb12469de2 TO IDX_5F0A47412469DE2');
    }
}
