<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009104804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arrangement (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE back_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4624E507E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ergonomy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE front_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(180) NOT NULL, lastname VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_B5436C25E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hall (id INT AUTO_INCREMENT NOT NULL, arrangement_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, capacity INT NOT NULL, INDEX IDX_1B8FA83FC5CAAFBC (arrangement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hall_ergonomy (hall_id INT NOT NULL, ergonomy_id INT NOT NULL, INDEX IDX_581A618C52AFCFD6 (hall_id), INDEX IDX_581A618C45CF4AB6 (ergonomy_id), PRIMARY KEY(hall_id, ergonomy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hall_material (hall_id INT NOT NULL, material_id INT NOT NULL, INDEX IDX_CD11AB8C52AFCFD6 (hall_id), INDEX IDX_CD11AB8CE308AC6F (material_id), PRIMARY KEY(hall_id, material_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hall_software (hall_id INT NOT NULL, software_id INT NOT NULL, INDEX IDX_C67FB6D652AFCFD6 (hall_id), INDEX IDX_C67FB6D6D7452741 (software_id), PRIMARY KEY(hall_id, software_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, hall_id INT DEFAULT NULL, front_user_id INT NOT NULL, startdate DATETIME NOT NULL, enddate DATETIME NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_42C8495552AFCFD6 (hall_id), INDEX IDX_42C849557E5A750F (front_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE software (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hall ADD CONSTRAINT FK_1B8FA83FC5CAAFBC FOREIGN KEY (arrangement_id) REFERENCES arrangement (id)');
        $this->addSql('ALTER TABLE hall_ergonomy ADD CONSTRAINT FK_581A618C52AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hall_ergonomy ADD CONSTRAINT FK_581A618C45CF4AB6 FOREIGN KEY (ergonomy_id) REFERENCES ergonomy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hall_material ADD CONSTRAINT FK_CD11AB8C52AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hall_material ADD CONSTRAINT FK_CD11AB8CE308AC6F FOREIGN KEY (material_id) REFERENCES material (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hall_software ADD CONSTRAINT FK_C67FB6D652AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hall_software ADD CONSTRAINT FK_C67FB6D6D7452741 FOREIGN KEY (software_id) REFERENCES software (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495552AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849557E5A750F FOREIGN KEY (front_user_id) REFERENCES front_user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hall DROP FOREIGN KEY FK_1B8FA83FC5CAAFBC');
        $this->addSql('ALTER TABLE hall_ergonomy DROP FOREIGN KEY FK_581A618C52AFCFD6');
        $this->addSql('ALTER TABLE hall_ergonomy DROP FOREIGN KEY FK_581A618C45CF4AB6');
        $this->addSql('ALTER TABLE hall_material DROP FOREIGN KEY FK_CD11AB8C52AFCFD6');
        $this->addSql('ALTER TABLE hall_material DROP FOREIGN KEY FK_CD11AB8CE308AC6F');
        $this->addSql('ALTER TABLE hall_software DROP FOREIGN KEY FK_C67FB6D652AFCFD6');
        $this->addSql('ALTER TABLE hall_software DROP FOREIGN KEY FK_C67FB6D6D7452741');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495552AFCFD6');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849557E5A750F');
        $this->addSql('DROP TABLE arrangement');
        $this->addSql('DROP TABLE back_user');
        $this->addSql('DROP TABLE ergonomy');
        $this->addSql('DROP TABLE front_user');
        $this->addSql('DROP TABLE hall');
        $this->addSql('DROP TABLE hall_ergonomy');
        $this->addSql('DROP TABLE hall_material');
        $this->addSql('DROP TABLE hall_software');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE software');
    }
}
