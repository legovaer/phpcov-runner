<?php
/**
 * @file
 * Contains
 */

namespace Legovaer\PHPCOVRunner\Command;


use Legovaer\PHPCOVRunner\Driver\XdebugSQLite3;
use SebastianBergmann\PHPCOV\BaseCommand;
use Symfony\Component\Console\Command\Command as AbstractCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExecuteCommand extends AbstractCommand
{

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('execute')
          ->addArgument(
            'script',
            InputArgument::REQUIRED,
            'Script to execute'
          )
          ->addArgument(
            'variables',
            InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
            'Set extra variables'
          );
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
        $this->cleanUpVariables($input);

        $driver = XdebugSQLite3::getInstance();
        $driver->start();

        require $input->getArgument('script');

        $driver->stop();
    }

    /**
     * Cleans up the server variables so that the called script thinks that it's been executed by the CLI.
     *
     * @param InputInterface $input
     */
    protected function cleanUpVariables(InputInterface $input) {
        unset($_SERVER['argv'][0]);
        $_SERVER['argv'][1] = 'php';
        foreach ($input->getArgument('variables') as $var) {
            $explode = explode('\\', $var);
            $pos = array_search($var, $_SERVER['argv']);
            unset($_SERVER['argv'][$pos]);
            $_SERVER['argv'][] = $explode[1];
        }
        array_values($_SERVER['argv']);
    }
}
