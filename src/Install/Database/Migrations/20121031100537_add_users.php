<?php namespace App\Database\Migrations;

class AddUsers extends Migration 
{
public function up()
{
    $this->forge->addField([
            'id'            => [
                'type'           => 'INT',
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'firstname'     => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null'           => FALSE,
            ],
            'lastname'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null'           => FALSE,
             ],
            'email'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null'           => FALSE,
               ],
            'password'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => FALSE,
            ],
            'created_at'     => [
                'type'           => 'DATETIME',
                'null'           => TRUE,
                'default'        => 'current_timestamp()',
            ],
            'updated_at'     => [
                'type'           => 'DATETIME',
                'null'           => TRUE,
                'default'        => 'current_timestamp()',
            ]
            ]);
    $this->forge->addKey('id', TRUE);
    $this->forge->createTable('users');
}

    public function down()
    {
            $this->forge->dropTable('users');
    }
}