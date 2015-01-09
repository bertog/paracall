<?php


namespace Paracall\Application;


use Symfony\Component\Console\Application;

class ParacallApp extends Application  {

    public $baseDir;

    public function __construct()
    {
        parent::__construct();
    }

    public function setBaseDir($directory)
    {
       $this->baseDir = $directory;
    }




}