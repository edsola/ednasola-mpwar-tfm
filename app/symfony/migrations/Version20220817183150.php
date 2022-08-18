<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220817183150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, ticket_id INT NOT NULL, user_id INT NOT NULL, comment LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_9474526C700047D2 (ticket_id), INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE label (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE priority (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, technician_user_id_id INT NOT NULL, priority_id_id INT NOT NULL, status_id_id INT NOT NULL, admin_user_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_date DATETIME NOT NULL, completed_date DATETIME DEFAULT NULL, INDEX IDX_97A0ADA367810A5A (technician_user_id_id), INDEX IDX_97A0ADA380838C8A (priority_id_id), INDEX IDX_97A0ADA3881ECFA7 (status_id_id), INDEX IDX_97A0ADA355B8C38A (admin_user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_label (ticket_id INT NOT NULL, label_id INT NOT NULL, INDEX IDX_26973363700047D2 (ticket_id), INDEX IDX_2697336333B92F39 (label_id), PRIMARY KEY(ticket_id, label_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA367810A5A FOREIGN KEY (technician_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA380838C8A FOREIGN KEY (priority_id_id) REFERENCES priority (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3881ECFA7 FOREIGN KEY (status_id_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA355B8C38A FOREIGN KEY (admin_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket_label ADD CONSTRAINT FK_26973363700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket_label ADD CONSTRAINT FK_2697336333B92F39 FOREIGN KEY (label_id) REFERENCES label (id) ON DELETE CASCADE');

        $role = '["ROLE_ADMIN"]';
        $this->addSql("INSERT INTO user (email, roles, password, name, surname, username) VALUES ('admin@admin.com', '". $role ."', '$2y$13$3wt4NQtThaq1h5f6krBgme2Cpt8uan9XLlI6ez4WjH8Imhw6WZ0Te', 'admin', 'admin', 'admin')");

        $this->addSql("INSERT INTO role (name) VALUES ('admin'), ('technician')");
        $this->addSql("INSERT INTO priority (name) VALUES ('low'), ('medium'), ('high')");
        $this->addSql("INSERT INTO label (name) VALUES ('software'), ('hardware'), ('cloud'), ('host'), ('email')");
        $this->addSql("INSERT INTO status (name) VALUES ('open'), ('completed'), ('closed')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket_label DROP FOREIGN KEY FK_2697336333B92F39');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA380838C8A');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3881ECFA7');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C700047D2');
        $this->addSql('ALTER TABLE ticket_label DROP FOREIGN KEY FK_26973363700047D2');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA367810A5A');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA355B8C38A');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE label');
        $this->addSql('DROP TABLE priority');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ticket_label');
        $this->addSql('DROP TABLE user');
    }
}
