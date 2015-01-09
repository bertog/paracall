<?php


namespace Paracall\Database;


class Database {

    public $host;

    public $database;

    public $username;

    public $password;

    public $prefix;

    function __construct($host, $database, $username, $password, $prefix = '')
    {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->prefix = $prefix;
    }


}