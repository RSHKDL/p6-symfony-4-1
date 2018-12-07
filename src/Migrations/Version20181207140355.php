<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181207140355 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_tricks (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, image_featured_id INT DEFAULT NULL, name VARCHAR(140) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_4DA6F41989D9B62 (slug), INDEX IDX_4DA6F41F675F31B (author_id), UNIQUE INDEX UNIQ_4DA6F41CCD0B4AD (image_featured_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_tricks_categories (trick_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_6BF1EA9FB281BE2E (trick_id), INDEX IDX_6BF1EA9F12469DE2 (category_id), PRIMARY KEY(trick_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_tricks_images (trick_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_4ED56A04B281BE2E (trick_id), INDEX IDX_4ED56A043DA5256D (image_id), PRIMARY KEY(trick_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_images (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_comments (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, author_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_571EF687B281BE2E (trick_id), INDEX IDX_571EF687F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_videos (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, type VARCHAR(255) NOT NULL, video_id VARCHAR(255) NOT NULL, INDEX IDX_CCA909B2B281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(32) NOT NULL, email VARCHAR(32) NOT NULL, password VARCHAR(64) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', is_active TINYINT(1) NOT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_C2502824F85E0677 (username), UNIQUE INDEX UNIQ_C2502824E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_tricks ADD CONSTRAINT FK_4DA6F41F675F31B FOREIGN KEY (author_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE app_tricks ADD CONSTRAINT FK_4DA6F41CCD0B4AD FOREIGN KEY (image_featured_id) REFERENCES app_images (id)');
        $this->addSql('ALTER TABLE app_tricks_categories ADD CONSTRAINT FK_6BF1EA9FB281BE2E FOREIGN KEY (trick_id) REFERENCES app_tricks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_tricks_categories ADD CONSTRAINT FK_6BF1EA9F12469DE2 FOREIGN KEY (category_id) REFERENCES app_categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_tricks_images ADD CONSTRAINT FK_4ED56A04B281BE2E FOREIGN KEY (trick_id) REFERENCES app_tricks (id)');
        $this->addSql('ALTER TABLE app_tricks_images ADD CONSTRAINT FK_4ED56A043DA5256D FOREIGN KEY (image_id) REFERENCES app_images (id)');
        $this->addSql('ALTER TABLE app_comments ADD CONSTRAINT FK_571EF687B281BE2E FOREIGN KEY (trick_id) REFERENCES app_tricks (id)');
        $this->addSql('ALTER TABLE app_comments ADD CONSTRAINT FK_571EF687F675F31B FOREIGN KEY (author_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE app_videos ADD CONSTRAINT FK_CCA909B2B281BE2E FOREIGN KEY (trick_id) REFERENCES app_tricks (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_tricks_categories DROP FOREIGN KEY FK_6BF1EA9FB281BE2E');
        $this->addSql('ALTER TABLE app_tricks_images DROP FOREIGN KEY FK_4ED56A04B281BE2E');
        $this->addSql('ALTER TABLE app_comments DROP FOREIGN KEY FK_571EF687B281BE2E');
        $this->addSql('ALTER TABLE app_videos DROP FOREIGN KEY FK_CCA909B2B281BE2E');
        $this->addSql('ALTER TABLE app_tricks DROP FOREIGN KEY FK_4DA6F41CCD0B4AD');
        $this->addSql('ALTER TABLE app_tricks_images DROP FOREIGN KEY FK_4ED56A043DA5256D');
        $this->addSql('ALTER TABLE app_tricks_categories DROP FOREIGN KEY FK_6BF1EA9F12469DE2');
        $this->addSql('ALTER TABLE app_tricks DROP FOREIGN KEY FK_4DA6F41F675F31B');
        $this->addSql('ALTER TABLE app_comments DROP FOREIGN KEY FK_571EF687F675F31B');
        $this->addSql('DROP TABLE app_tricks');
        $this->addSql('DROP TABLE app_tricks_categories');
        $this->addSql('DROP TABLE app_tricks_images');
        $this->addSql('DROP TABLE app_images');
        $this->addSql('DROP TABLE app_comments');
        $this->addSql('DROP TABLE app_videos');
        $this->addSql('DROP TABLE app_categories');
        $this->addSql('DROP TABLE app_users');
    }
}
