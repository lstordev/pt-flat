<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250524064147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create product table with fields: id, name, price, created_at';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('product');

        $table->addColumn('id', 'integer', [
            'autoincrement' => true,
        ]);
        $table->addColumn('name', 'string', [
            'length' => 255,
            'notnull' => true,
        ]);
        $table->addColumn('price', 'float', [
            'notnull' => true,
        ]);
        $table->addColumn('created_at', 'datetime', [
            'notnull' => true,
        ]);

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('product');
    }
}
