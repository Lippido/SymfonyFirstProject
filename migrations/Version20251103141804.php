<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251103141804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, spotify_url VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, spotify_id VARCHAR(255) DEFAULT NULL, picture_link VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, followers INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist_user (artist_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_312D50D6B7970CF8 (artist_id), INDEX IDX_312D50D6A76ED395 (user_id), PRIMARY KEY(artist_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE track (id INT AUTO_INCREMENT NOT NULL, disc_number INT DEFAULT NULL, authors VARCHAR(255) DEFAULT NULL, duration_ms INT DEFAULT NULL, explicit TINYINT(1) DEFAULT NULL, isrc LONGTEXT DEFAULT NULL, spotify_url LONGTEXT NOT NULL, href LONGTEXT DEFAULT NULL, spotify_id LONGTEXT DEFAULT NULL, is_local TINYINT(1) DEFAULT NULL, name LONGTEXT DEFAULT NULL, popularity INT DEFAULT NULL, preview_url LONGTEXT DEFAULT NULL, track_number INT DEFAULT NULL, type LONGTEXT DEFAULT NULL, uri LONGTEXT DEFAULT NULL, picture_link LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_favorite_tracks (user_id INT NOT NULL, track_id INT NOT NULL, INDEX IDX_A042A5BA76ED395 (user_id), INDEX IDX_A042A5B5ED23C43 (track_id), PRIMARY KEY(user_id, track_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_favorite_artists (user_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_48926CADA76ED395 (user_id), INDEX IDX_48926CADB7970CF8 (artist_id), PRIMARY KEY(user_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist_user ADD CONSTRAINT FK_312D50D6B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artist_user ADD CONSTRAINT FK_312D50D6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_favorite_tracks ADD CONSTRAINT FK_A042A5BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_favorite_tracks ADD CONSTRAINT FK_A042A5B5ED23C43 FOREIGN KEY (track_id) REFERENCES track (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_favorite_artists ADD CONSTRAINT FK_48926CADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_favorite_artists ADD CONSTRAINT FK_48926CADB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist_user DROP FOREIGN KEY FK_312D50D6B7970CF8');
        $this->addSql('ALTER TABLE artist_user DROP FOREIGN KEY FK_312D50D6A76ED395');
        $this->addSql('ALTER TABLE user_favorite_tracks DROP FOREIGN KEY FK_A042A5BA76ED395');
        $this->addSql('ALTER TABLE user_favorite_tracks DROP FOREIGN KEY FK_A042A5B5ED23C43');
        $this->addSql('ALTER TABLE user_favorite_artists DROP FOREIGN KEY FK_48926CADA76ED395');
        $this->addSql('ALTER TABLE user_favorite_artists DROP FOREIGN KEY FK_48926CADB7970CF8');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE artist_user');
        $this->addSql('DROP TABLE track');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_favorite_tracks');
        $this->addSql('DROP TABLE user_favorite_artists');
    }
}
