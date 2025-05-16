<?php
declare(strict_types=1);

namespace App\Console\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;

class ListUsersCommand extends Command
{
    protected function execute(Arguments $args, ConsoleIo $io): int
    {
        $usersTable = $this->getTableLocator()->get('Users');
        $users = $usersTable->find()->toList();

        foreach ($users as $user) {
            $io->out("ID: {$user->id}, Username: {$user->username}");
        }

        return Command::SUCCESS;
    }
}
