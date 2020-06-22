<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200622223858 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE topping_pizza (topping_id INT NOT NULL, pizza_id INT NOT NULL, INDEX IDX_A8034CCFE9C2067C (topping_id), INDEX IDX_A8034CCFD41D1D42 (pizza_id), PRIMARY KEY(topping_id, pizza_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE topping_pizza ADD CONSTRAINT FK_A8034CCFE9C2067C FOREIGN KEY (topping_id) REFERENCES topping (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE topping_pizza ADD CONSTRAINT FK_A8034CCFD41D1D42 FOREIGN KEY (pizza_id) REFERENCES pizza (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE topping_pizza');
    }
}
