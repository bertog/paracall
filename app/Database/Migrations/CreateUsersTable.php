<?php


namespace Paracall\Database\Migrations;


use Illuminate\Database\Capsule\Manager;
use Paracall\Database\Migration;

class CreateUsersTable extends Migration {

    public function up()
    {
        Manager::schema()->create('users', function($table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }
}