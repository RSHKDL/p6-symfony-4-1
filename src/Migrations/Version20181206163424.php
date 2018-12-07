<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181206163424 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_figures_images (trick_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_6250058CB281BE2E (trick_id), INDEX IDX_6250058C3DA5256D (image_id), PRIMARY KEY(trick_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_figures_images ADD CONSTRAINT FK_6250058CB281BE2E FOREIGN KEY (trick_id) REFERENCES app_figures (id)');
        $this->addSql('ALTER TABLE app_figures_images ADD CONSTRAINT FK_6250058C3DA5256D FOREIGN KEY (image_id) REFERENCES app_images (id)');
        $this->addSql('ALTER TABLE app_figures ADD author_id INT NOT NULL, ADD image_featured_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE app_figures_images');
        $this->addSql('ALTER TABLE app_figures DROP author_id, DROP image_featured_id');
    }
}
