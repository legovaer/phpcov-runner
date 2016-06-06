<?php

$files = [
  __DIR__ . '/../../autoload.php',
  __DIR__ . '/vendor/autoload.php',
  __DIR__ . '/../vendor/autoload.php',
  __DIR__ . '/../../../autoload.php',
];

foreach ($files as $file) {
    if (file_exists($file)) {
        require $file;
        $loaded = true;
        break;
    }
}

if (!$loaded) {
    die(
      'You need to set up the project dependencies using the following commands:' . PHP_EOL .
      'wget http://getcomposer.org/composer.phar' . PHP_EOL .
      'php composer.phar install' . PHP_EOL
    );
}

use Legovaer\PHPCOVRunner\Driver\XdebugSQLite3 as Driver;
use PHP_CodeCoverage as CodeCoverage;

if (Driver::isCoverageOn()) {
    $driver = Driver::getInstance();
    $coverage = new CodeCoverage($driver);
    $coverage->start('phpcov');
    register_shutdown_function('stop_coverage');
}

/**
 * Stops the current coverage analysis.
 */
function stop_coverage()
{
    // hack until i can think of a way to run tests first and w/o exiting.
    $autorun = function_exists('run_local_tests');
    if ($autorun) {
        $result = run_local_tests();
    }
    Driver::getInstance()->stop();
    if ($autorun) {
        exit($result ? 0 : 1);
    }
}
