<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181003165334 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD customer_stripe VARCHAR(255) NOT NULL, ADD date_debut_abonnement DATE DEFAULT NULL, CHANGE photo photo VARCHAR(255) NOT NULL, CHANGE lieux lieux INT NOT NULL, CHANGE points points INT NOT NULL, CHANGE grade grade VARCHAR(255) NOT NULL, CHANGE nepasderanger nepasderanger TINYINT(1) NOT NULL, CHANGE mobile mobile VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP customer_stripe, DROP date_debut_abonnement, CHANGE photo photo VARCHAR(255) DEFAULT \'/build/images/photo.png\' NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE lieux lieux INT DEFAULT 0 NOT NULL, CHANGE points points INT DEFAULT 0 NOT NULL, CHANGE grade grade VARCHAR(255) DEFAULT \'Sauce Moutarde\' NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE nepasderanger nepasderanger TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE mobile mobile VARCHAR(255) DEFAULT \'0000000000\' NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
