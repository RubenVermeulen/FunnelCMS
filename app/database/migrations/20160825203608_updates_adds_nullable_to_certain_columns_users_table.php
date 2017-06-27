<?php

use Phinx\Migration\AbstractMigration;

class UpdatesAddsNullableToCertainColumnsUsersTable extends AbstractMigration
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
        $table = $this->table('users');

        $table
            ->changeColumn('first_name', 'string', ['limit' => 45, 'null' => true])
            ->changeColumn('last_name', 'string', ['limit' => 45, 'null' => true])
            ->changeColumn('password', 'string', ['limit' => 255, 'null' => true])
            ->changeColumn('active_hash', 'string', ['limit' => 255, 'null' => true])
            ->changeColumn('recover_hash', 'string', ['limit' => 255, 'null' => true])
            ->changeColumn('remember_identifier', 'string', ['limit' => 255, 'null' => true])
            ->changeColumn('remember_token', 'string', ['limit' => 255, 'null' => true])
            ->save();
    }
}
