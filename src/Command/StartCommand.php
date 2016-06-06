<?php

namespace Legovaer\PHPCOVRunner\Command;

use Legovaer\PHPCOVRunner\Driver\XdebugSQLite3;
use Symfony\Component\Console\Command\Command as AbstractCommand;

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
    protected function execute()
    {
        $driver = new XdebugSQLite3();
        $driver->resetLog();
    }
}
