<?php
/*
 * This file is part of phpcov.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Legovaer\PHPCOVRunner;

use SebastianBergmann\Version;
use Symfony\Component\Console\Application as AbstractApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Legovaer\PHPCOVRunner\Command\StartCommand;
use Legovaer\PHPCOVRunner\Command\StopCommand;

/**
 * TextUI frontend for php-code-coverage.
 *
 * @since Class available since Release 2.0.0
 */
class Application extends AbstractApplication
{
    public function __construct()
    {
        $version = new Version('1.0.0', dirname(__DIR__));
        parent::__construct('phpcov-runner', $version->getVersion());

        $this->add(new StartCommand);
        $this->add(new StopCommand);
    }

    /**
     * Runs the current application.
     *
     * @param InputInterface  $input  An Input instance
     * @param OutputInterface $output An Output instance
     *
     * @return int 0 if everything went fine, or an error code
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        if (!$input->hasParameterOption('--quiet')) {
            $output->write(
              sprintf(
                "phpcov-runner %s by Levi Govaerts.\n\n",
                $this->getVersion()
              )
            );
        }

        if ($input->hasParameterOption('--version') ||
          $input->hasParameterOption('-V')) {
            exit;
        }

        parent::doRun($input, $output);
    }
}
