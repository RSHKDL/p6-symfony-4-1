<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180825165315 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_videos (id INT AUTO_INCREMENT NOT NULL, figure_id INT NOT NULL, type VARCHAR(255) NOT NULL, video_id VARCHAR(255) NOT NULL, INDEX IDX_CCA909B25C011B5 (figure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_videos ADD CONSTRAINT FK_CCA909B25C011B5 FOREIGN KEY (figure_id) REFERENCES app_figures (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER_TABLE app_videos DROP FOREIGN KEY FK_CCA909B25C011B5');
        $this->addSql('DROP INDEX IDX_CCA909B25C011B5 ON app_videos');
        $this->addSql('DROP TABLE app_videos');
    }
}
