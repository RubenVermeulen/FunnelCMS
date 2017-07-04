<?php

use Phinx\Migration\AbstractMigration;

class CreateArticlesTable extends AbstractMigration
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
        $table = $this->table('articles');

        $table
            ->addColumn('user_id', 'integer')
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addColumn('subject', 'string', ['limit' => 150])
            ->addColumn('summary', 'string', ['limit' => 255])
            ->addColumn('content', 'text')
            ->addTimestamps()
            ->addColumn('published_at', 'timestamp', ['null' => true])
            ->save();
    }
}
