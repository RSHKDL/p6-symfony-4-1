<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180816173622 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_images ADD figure_id INT NOT NULL');
        $this->addSql('ALTER TABLE app_images ADD CONSTRAINT FK_51CD3EA5C011B5 FOREIGN KEY (figure_id) REFERENCES app_figures (id)');
        $this->addSql('CREATE INDEX IDX_51CD3EA5C011B5 ON app_images (figure_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_images DROP FOREIGN KEY FK_51CD3EA5C011B5');
        $this->addSql('DROP INDEX IDX_51CD3EA5C011B5 ON app_images');
        $this->addSql('ALTER TABLE app_images DROP figure_id');
    }
}
