<?php

use Phinx\Migration\AbstractMigration;

class CreateInitialTables extends AbstractMigration
{
    public function change()
    {
        // Create the meters table
        $table = $this->table('meters');
        $table->addColumn('name', 'string', ['limit' => 256, 'null' => false])
              ->addColumn('identifier', 'string', ['limit' => 128, 'null' => false])
              ->addColumn('utility', 'string', ['limit' => 128, 'null' => false])
              ->addColumn('protocol', 'integer', ['null' => false])
              ->addColumn('type', 'integer', ['null' => false])
              ->addColumn('unit', 'string', ['limit' => 64, 'null' => false])
              ->addColumn('multiplier', 'float', ['default' => 1.0, 'null' => false])
              ->addColumn('disabled', 'boolean', ['default' => false])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
              ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
              ->addIndex(['id'])
              ->create();

        // Create the readings table
        $table = $this->table('readings');
        $table->addColumn('meter_id', 'integer', ['null' => false])
              ->addColumn('value', 'integer', ['null' => false])
              ->addColumn('consumption', 'integer', ['null' => false])
              ->addColumn('interval', 'integer', ['null' => false])
              ->addColumn('reset', 'boolean', ['default' => false])
              ->addColumn('inferred', 'boolean', ['default' => false])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
              ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
              ->addForeignKey('meter_id', 'meters', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
              ->addIndex(['id'])
              ->addIndex(['meter_id'])
              ->addIndex(['interval'])
              ->addIndex(['created_at'])
              ->create();
    }
}
