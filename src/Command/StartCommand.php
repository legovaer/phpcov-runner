<?php
/**
 * @file
 * Contains
 */

namespace Legovaer\PHPCOVRunner\Command;

use Legovaer\PHPCOVRunner\CodeCoverage;
use Legovaer\PHPCOVRunner\Driver\XdebugSQLite3;
use Symfony\Component\Console\Command\Command as AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int null or 0 if everything went fine, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $driver = new XdebugSQLite3();
        $driver->resetLog();
    }
}