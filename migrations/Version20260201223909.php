<?php
declare(strict_types=1);
namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20260201223909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add logic delete and history';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aio_challenge ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE aio_challenge ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE aio_challenge ADD deleted BOOLEAN NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aio_challenge DROP created_at');
        $this->addSql('ALTER TABLE aio_challenge DROP updated_at');
        $this->addSql('ALTER TABLE aio_challenge DROP deleted');
    }
}
