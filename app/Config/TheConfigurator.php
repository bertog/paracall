<?php


namespace Paracall\Config;


use Paracall\Database\Database;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TheConfigurator
 *
 * Read the Global App Configuration
 *
 * @package Paracall\Config
 */
class TheConfigurator {

    protected $baseDir;

    function __construct($baseDir)
    {
        $this->baseDir = $baseDir;
    }


    /**
     * Read the Database Node and return the relevant info for database connection
     *
     * @return mixed
     */
    public function DatabaseConfig()
    {

        $config = Yaml::parse($this->baseDir . '/app/Config/dbconfig.yml');

        $config = $config['connections'][$config['default_connection']];

        extract($config);

        return new Database($host, $database, $username, $password);
    }

}