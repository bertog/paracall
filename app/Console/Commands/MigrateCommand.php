<?php


namespace Paracall\Console\Commands;


use Paracall\Config\TheConfigurator;
use Paracall\Database\Migrator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends Command {

    protected $baseDir;
    protected $namespace;

    function __construct($baseDir, $namespace)
    {
        $this->baseDir = $baseDir;
        $this->namespace = $namespace;
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
        $config = new TheConfigurator($this->baseDir);

        $migrationClass = $this->namespace . '\\Database\\Migrations\\' . $input->getArgument('migration');

        $migrator = New Migrator($config);

        $migration = new $migrationClass();

        $migrator->DoTheMigration($migration);

        $output->writeln("<info>Table Successfully Migrated</info>");

    }
}