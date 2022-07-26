<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220721142357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket ADD admin_user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA355B8C38A FOREIGN KEY (admin_user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA355B8C38A ON ticket (admin_user_id_id)');

        $role = '[{"roles" : "ROLE_ADMIN"}]';
        $this->addSql("INSERT INTO user (email, roles, password, name, surname, username) VALUES ('admin@admin.com', '". $role ."', 'admin123', 'admin', 'admin', 'admin')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA355B8C38A');
        $this->addSql('DROP INDEX IDX_97A0ADA355B8C38A ON ticket');
        $this->addSql('ALTER TABLE ticket DROP admin_user_id_id');
    }
}
