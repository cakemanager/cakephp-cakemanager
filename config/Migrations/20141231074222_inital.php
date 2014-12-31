<?php

use Phinx\Migration\AbstractMigration;

class Inital extends AbstractMigration
{

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * @return void
     */
    public function change() {

        $exists = $this->hasTable('metas');
        if (!$exists) {

            $table = $this->table('metas');
            $table
                    ->addColumn('rel_model', 'string', [
                        'limit'   => '50',
                        'null'    => true,
                        'default' => '',
                    ])
                    ->addColumn('rel_id', 'integer', [
                        'limit'  => '11',
                        'signed' => '',
                        'null'   => true,
                    ])
                    ->addColumn('name', 'string', [
                        'limit'   => '256',
                        'null'    => true,
                        'default' => '',
                    ])
                    ->addColumn('value', 'text', [
                        'limit'   => '',
                        'null'    => true,
                        'default' => '',
                    ])
                    ->addColumn('created', 'datetime', [
                        'limit' => '',
                        'null'  => true,
                    ])
                    ->addColumn('modified', 'datetime', [
                        'limit' => '',
                        'null'  => true,
                    ])
                    ->save();
        }

        $exists = $this->hasTable('roles');
        if (!$exists) {


            $table = $this->table('roles');
            $table
                    ->addColumn('name', 'string', [
                        'limit'   => '50',
                        'null'    => '',
                        'default' => '0',
                    ])
                    ->addColumn('login_redirect', 'string', [
                        'limit'   => '256',
                        'null'    => true,
                        'default' => '',
                    ])
                    ->addColumn('created', 'datetime', [
                        'limit'   => '',
                        'null'    => '',
                        'default' => '0000-00-00 00:00:00',
                    ])
                    ->addColumn('modified', 'datetime', [
                        'limit'   => '',
                        'null'    => '',
                        'default' => '0000-00-00 00:00:00',
                    ])
                    ->save();
        }

        $exists = $this->hasTable('users');
        if (!$exists) {


            $table = $this->table('users');
            $table
                    ->addColumn('role_id', 'integer', [
                        'limit'  => '11',
                        'signed' => '',
                        'null'   => true,
                    ])
                    ->addColumn('email', 'string', [
                        'limit'   => '255',
                        'null'    => '',
                        'default' => '',
                    ])
                    ->addColumn('password', 'string', [
                        'limit'   => '255',
                        'null'    => '',
                        'default' => '',
                    ])
                    ->addColumn('created', 'datetime', [
                        'limit'   => '',
                        'null'    => true,
                        'default' => '0000-00-00 00:00:00',
                    ])
                    ->addColumn('modified', 'datetime', [
                        'limit'   => '',
                        'null'    => true,
                        'default' => '0000-00-00 00:00:00',
                    ])
                    ->save();
        }
    }

    /**
     * Migrate Up.
     *
     * @return void
     */
    public function up() {

    }

    /**
     * Migrate Down.
     *
     * @return void
     */
    public function down() {

    }

}
