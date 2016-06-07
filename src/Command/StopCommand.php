<?php

namespace Drupal\PHPCOVRunner\Command;

use Drupal\PHPCOVRunner\Driver\XdebugSQLite3;
use SebastianBergmann\PHPCOV\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Stop command based on the ExecuteCommand.
 *
 * @see ExecuteCommand
 */
class StopCommand extends BaseCommand
{

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        parent::configure();
        $this->setName('stop')
          ->addOption(
              'configuration',
              null,
              InputOption::VALUE_REQUIRED,
              'Read configuration from XML file'
          )
          ->addOption(
              'blacklist',
              null,
              InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
              'Add directory or file to the blacklist'
          )
          ->addOption(
              'whitelist',
              null,
              InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
              'Add directory or file to the whitelist'
          )
          ->addOption(
              'add-uncovered',
              null,
              InputOption::VALUE_NONE,
              'Add whitelisted files that are not covered'
          )
          ->addOption(
              'process-uncovered',
              null,
              InputOption::VALUE_NONE,
              'Process whitelisted files that are not covered'
          )
          ->addOption(
              'clover',
              null,
              InputOption::VALUE_REQUIRED,
              'Generate code coverage report in Clover XML format'
          )
          ->addOption(
              'crap4j',
              null,
              InputOption::VALUE_REQUIRED,
              'Generate code coverage report in Crap4J XML format'
          )
          ->addOption(
              'html',
              null,
              InputOption::VALUE_REQUIRED,
              'Generate code coverage report in HTML format'
          )
          ->addOption(
              'php',
              null,
              InputOption::VALUE_REQUIRED,
              'Export PHP_CodeCoverage object to file'
          )
          ->addOption(
              'text',
              null,
              InputOption::VALUE_REQUIRED,
              'Generate code coverage report in text format'
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
        $driver = XdebugSQLite3::getInstance();
        $coverage = new \PHP_CodeCoverage($driver);

        $this->handleConfiguration($coverage, $input);
        $this->handleFilter($coverage, $input);

        $coverage->start('phpcov');
        $coverage->stop();

        $this->handleReports($coverage, $input, $output);
    }

}