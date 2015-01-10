<?php


namespace Paracall\Console;


use Paracall\Config\TheConfigurator;
use Symfony\Component\Console\Application;

class ParacallApp extends Application  {

    public $baseDir;

    public $namespace;

    public function __construct()
    {
        parent::__construct();
    }

    public function setBaseDir($directory)
    {
       $this->baseDir = $directory;
    }

    public function getAppNamespace()
    {
        $config = new TheConfigurator($this->baseDir);

        return $config->AppConfig()->namespace;
    }
}