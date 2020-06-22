<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200622222001 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_pizza (order_id INT NOT NULL, pizza_id INT NOT NULL, INDEX IDX_4C43F6928D9F6D38 (order_id), INDEX IDX_4C43F692D41D1D42 (pizza_id), PRIMARY KEY(order_id, pizza_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_pizza ADD CONSTRAINT FK_4C43F6928D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_pizza ADD CONSTRAINT FK_4C43F692D41D1D42 FOREIGN KEY (pizza_id) REFERENCES pizza (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE order_pizza');
    }
}
