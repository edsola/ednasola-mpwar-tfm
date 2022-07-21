<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220721132241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, technician_user_id_id INT NOT NULL, priority_id_id INT NOT NULL, status_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_date DATETIME NOT NULL, completed_date DATETIME NOT NULL, INDEX IDX_97A0ADA367810A5A (technician_user_id_id), INDEX IDX_97A0ADA380838C8A (priority_id_id), INDEX IDX_97A0ADA3881ECFA7 (status_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_label (ticket_id INT NOT NULL, label_id INT NOT NULL, INDEX IDX_26973363700047D2 (ticket_id), INDEX IDX_2697336333B92F39 (label_id), PRIMARY KEY(ticket_id, label_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA367810A5A FOREIGN KEY (technician_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA380838C8A FOREIGN KEY (priority_id_id) REFERENCES priority (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3881ECFA7 FOREIGN KEY (status_id_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE ticket_label ADD CONSTRAINT FK_26973363700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket_label ADD CONSTRAINT FK_2697336333B92F39 FOREIGN KEY (label_id) REFERENCES label (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket_label DROP FOREIGN KEY FK_26973363700047D2');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA367810A5A');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ticket_label');
        $this->addSql('DROP TABLE user');
    }
}
