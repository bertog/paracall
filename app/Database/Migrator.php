<?php


namespace Paracall\Database;


use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Paracall\Config\TheConfigurator;

class Migrator {

    public $capsule;

    public function __construct()
    {
        $this->capsule = new Manager;
        $this->boot();
    }

    protected function boot()
    {

        $dbconfig = TheConfigurator::DatabaseConfig();

        $this->capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => $dbconfig->host,
            'database'  => $dbconfig->database,
            'username'  => $dbconfig->username,
            'password'  => $dbconfig->password,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => $dbconfig->prefix
        ]);

        $this->capsule->setEventDispatcher(new Dispatcher(new Container));
        $this->capsule->setAsGlobal();

        $this->capsule->bootEloquent();
    }

    public function DoTheMigration(Migration $migration) {
        $migration->up();
    }
}