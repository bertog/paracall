<?php


namespace Paracall\Commands;


use Paracall\Config\TheConfigurator;
use Paracall\Database\Migrator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends Command {

    protected $baseDir;

    function __construct($baseDir)
    {
        $this->baseDir = $baseDir;
        parent::__construct();
    }


    public function configure()
    {
        $this->setName('migrate')
            ->setDescription('MigrateCommand The Database')
            ->addArgument('migration', InputArgument::REQUIRED, 'Migration To MigrateCommand');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $migrationClass = $input->getArgument('migration');

        $migrator = New Migrator(new TheConfigurator($this->baseDir));

        $migration = new $migrationClass();

        $migrator->DoTheMigration($migration);

    }
}