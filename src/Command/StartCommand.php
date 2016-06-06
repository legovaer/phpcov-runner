<?php

namespace Legovaer\PHPCOVRunner\Command;

use Legovaer\PHPCOVRunner\Driver\XdebugSQLite3;
use Symfony\Component\Console\Command\Command as AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command used for starting a code coverage analysis.
 */
class StartCommand extends AbstractCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('start');
    }

    /**
     * Executes the current command.
     **/
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $driver = new XdebugSQLite3();
        $driver->resetLog();
    }
}
