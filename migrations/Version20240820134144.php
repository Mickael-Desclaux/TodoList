<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820134144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task ALTER COLUMN creation_date TYPE TIMESTAMP(0) WITHOUT TIME ZONE USING creation_date::timestamp');
        $this->addSql('ALTER TABLE task ALTER COLUMN update_date TYPE TIMESTAMP(0) WITHOUT TIME ZONE USING update_date::timestamp');
        $this->addSql('ALTER TABLE task ALTER COLUMN limit_date TYPE TIMESTAMP(0) WITHOUT TIME ZONE USING limit_date::timestamp');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task ALTER COLUMN creation_date TYPE VARCHAR(10) USING creation_date::varchar');
        $this->addSql('ALTER TABLE task ALTER COLUMN update_date TYPE VARCHAR(10) USING update_date::varchar');
        $this->addSql('ALTER TABLE task ALTER COLUMN limit_date TYPE VARCHAR(10) USING limit_date::varchar');
    }
}