<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260123125850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Challenge table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE aio_challenge (id UUID NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, schedule VARCHAR(255) NOT NULL, value INT NOT NULL, unit VARCHAR(255) NOT NULL, validation_criteria VARCHAR(255) NOT NULL, fk_user_id UUID DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_D3D931045741EEB9 ON aio_challenge (fk_user_id)');
        $this->addSql('ALTER TABLE aio_challenge ADD CONSTRAINT FK_D3D931045741EEB9 FOREIGN KEY (fk_user_id) REFERENCES aio_user (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aio_challenge DROP CONSTRAINT FK_D3D931045741EEB9');
        $this->addSql('DROP TABLE aio_challenge');
    }
}
