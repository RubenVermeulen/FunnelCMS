<?php

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $users = [
            [
                'email' => 'admin@funnelcms.com',
                'first_name' => 'Harry',
                'last_name' => 'Potter',
                'password' => password_hash('password', PASSWORD_BCRYPT, ['cost' => 10]),
                'active' => 1,
                'active_hash' => null,
                'recover_hash' => null,
                'remember_identifier' => null,
                'remember_token' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->table('users')->insert($users)->save();

        $usersPermissions = [
            [
                'user_id' => $this->fetchRow('SELECT * FROM users ORDER BY created_at DESC LIMIT 1')['id'],
                'is_admin' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->table('users_permissions')->insert($usersPermissions)->save();
    }
}
