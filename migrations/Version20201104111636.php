<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201104111636 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentarios CHANGE user_id user_id INT DEFAULT NULL, CHANGE posts_id posts_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE posts CHANGE user_id user_id INT DEFAULT NULL, CHANGE category_id category_id INT NOT NULL, CHANGE likes likes VARCHAR(1000) DEFAULT NULL, CHANGE contenido contenido MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentarios CHANGE user_id user_id INT DEFAULT NULL, CHANGE posts_id posts_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE posts CHANGE user_id user_id INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL, CHANGE likes likes VARCHAR(1000) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE contenido contenido MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
