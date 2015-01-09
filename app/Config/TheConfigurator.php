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


    /**
     * Read the Database Node and return the relevant info for database connection
     *
     * @return mixed
     */
    public static function DatabaseConfig()
    {
        if ( $_SERVER['DOCUMENT_ROOT'] !== '' ) {
            $config =  Yaml::parse($_SERVER['DOCUMENT_ROOT'] . '/app/Config/dbconfig.yml');
        } else {
            $config =  Yaml::parse(__DIR__ . '/dbconfig.yml');
        }

        $config = $config['connections'][$config['default_connection']];

        extract($config);

        return new Database($host, $database, $username, $password);
    }

}