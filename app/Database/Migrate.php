<?php

use Paracall\Database\Migrations\CreateUsersTable;
use Paracall\Database\Migrator;

$migrator = new Migrator();

$migration = new CreateUsersTable($migrator->capsule);

return $migrator->DoTheMigration($migration);

