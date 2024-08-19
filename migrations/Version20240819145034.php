<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240819145034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task_category (task_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(task_id, category_id))');
        $this->addSql('CREATE INDEX IDX_468CF38D8DB60186 ON task_category (task_id)');
        $this->addSql('CREATE INDEX IDX_468CF38D12469DE2 ON task_category (category_id)');
        $this->addSql('ALTER TABLE task_category ADD CONSTRAINT FK_468CF38D8DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_category ADD CONSTRAINT FK_468CF38D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE task_category DROP CONSTRAINT FK_468CF38D8DB60186');
        $this->addSql('ALTER TABLE task_category DROP CONSTRAINT FK_468CF38D12469DE2');
        $this->addSql('DROP TABLE task_category');
        $this->addSql('ALTER TABLE task ADD category_id INT DEFAULT NULL');
    }
}
