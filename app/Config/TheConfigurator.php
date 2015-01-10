<?php


namespace Paracall\Config;


use Paracall\Database\Database;
use Symfony\Component\Config\FileLocator;
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
    protected $dbConfigFile;
    protected $appConfigFile;

    function __construct($baseDir)
    {
        $this->baseDir = $baseDir;
    }

    public function getConfigFiles()
    {
        $configLocation = [$this->baseDir . '/app/Config'];

        $locator = new FileLocator($configLocation);

        $this->appConfigFile = $locator->locate('appconfig.yml', null, false);
        $this->dbConfigFile = $locator->locate('dbconfig.yml', null, false);

    }

    /**
     * Read the Database Node and return the relevant info for database connection
     *
     * @return mixed
     */
    public function DatabaseConfig()
    {

        $config = Yaml::parse(file_get_contents($this->baseDir . '/app/Config/dbconfig.yml'));

        $config = $config['connections'][$config['default_connection']];

        extract($config);

        return new Database($host, $database, $username, $password, $prefix);
    }

    public function AppConfig()
    {
        $config = Yaml::parse(file_get_contents($this->baseDir . '/app/Config/appconfig.yml'));

        $config = $config['app_configuration'];

        extract($config);

        return new AppConfiguration($namespace);
    }

}