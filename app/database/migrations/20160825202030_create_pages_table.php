<?php

use Phinx\Migration\AbstractMigration;

class CreatePagesTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('pages');

        $table
            ->addColumn('name', 'string', ['limit' => 50])
            ->addColumn('slug', 'string', ['limit' => 100])
            ->addColumn('content', 'text')
            ->addColumn('is_visible', 'boolean', ['default' => true])
            ->addColumn('is_locked', 'boolean', ['default' => false])
            ->addColumn('priority', 'integer')
            ->addTimestamps()
            ->save();
    }
}
