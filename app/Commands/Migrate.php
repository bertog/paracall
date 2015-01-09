<?php


namespace Paracall\Commands;


use Paracall\Database\Migrator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Migrate extends Command {

    public function configure()
    {
        $this->setName('migrate')
            ->setDescription('Migrate The Database')
            ->addArgument('migration', InputArgument::REQUIRED, 'Migration To Migrate');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $migrationClass = $input->getArgument('migration');

        $migrator = New Migrator();

        $migration = new $migrationClass();

        $migrator->DoTheMigration($migration);

    }
}