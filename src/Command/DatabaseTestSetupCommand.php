<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(name: 'app:test:database')]
class DatabaseTestSetupCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = $this->getApplication()->find('doctrine:database:create');
        $command2 = $this->getApplication()->find('doctrine:schema:create');
        $command3 = $this->getApplication()->find('doctrine:fixtures:load');

        $greetInput = new ArrayInput([]);
        $command->run($greetInput, new NullOutput());
        $command2->run($greetInput, new NullOutput());
        $returnCode3 = $command3->run($greetInput, $output);

        return $returnCode3;
    }
}