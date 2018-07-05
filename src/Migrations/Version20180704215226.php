<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180704215226 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_figures_categories (figure_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_5F0A4745C011B5 (figure_id), INDEX IDX_5F0A47412469DE2 (category_id), PRIMARY KEY(figure_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_figures_categories ADD CONSTRAINT FK_5F0A4745C011B5 FOREIGN KEY (figure_id) REFERENCES app_figures (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_figures_categories ADD CONSTRAINT FK_5F0A47412469DE2 FOREIGN KEY (category_id) REFERENCES app_categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_figures_categories DROP FOREIGN KEY FK_5F0A47412469DE2');
        $this->addSql('DROP TABLE app_categories');
        $this->addSql('DROP TABLE app_figures_categories');
    }
}
