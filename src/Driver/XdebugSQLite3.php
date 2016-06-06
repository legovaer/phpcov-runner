<?php

namespace Legovaer\PHPCOVRunner\Driver;

use Legovaer\PHPCOVRunner\RuntimeException;
use Legovaer\PHPCOVRunner\Handler\Sqlite3Data as DataHandler;
use PHP_CodeCoverage_Driver_Xdebug as Xdebug;

/**
 * Driver for Xdebug's code coverage functionality which saves data to Sqlite3.
 *
 * @codeCoverageIgnore
 */
class XdebugSQLite3 extends Xdebug
{

    /**
     * The root folder of the project.
     *
     * @var string
     */
    public $root;

    /**
     *
     */
    public $log;

    /**
     * The name of the database.
     */
    const SQLITE_DB = '/tmp/coverage.sqlite';

    /**
     * @var XdebugSqlite3
     */
    public static $instance;

    /**
     * Stop collection of code coverage information and store it in Sqlite3.
     *
     * @return array
     */
    public function stop()
    {
        $cov = xdebug_get_code_coverage();
        xdebug_stop_code_coverage();

        if (!isset($this->root)) {
            $this->root = getcwd();
        }

        $dataHandler = new DataHandler(self::SQLITE_DB);
        chdir($this->root);
        $dataHandler->write($cov);
        $cleanData = $this->cleanup($dataHandler->read());
        unset($dataHandler); // release sqlite connection

        return $cleanData;
    }

    /**
     * Empties the Sqlite3 database.
     */
    public function resetLog()
    {
        $newFile = fopen(self::SQLITE_DB, 'w');
        if (!$newFile) {
            throw new RuntimeException('Could not create '.self::SQLITE_DB);
        }
        fclose($newFile);
        if (!chmod(self::SQLITE_DB, 0666)) {
            throw new RuntimeException('Could not change ownership on file '.self::SQLITE_DB);
        }
        $handler = new DataHandler(self::SQLITE_DB);
        $handler->createSchema();
    }

    /**
     * Loads the object instance.
     *
     * @return XdebugSqlite3
     *   A new object or the existing object.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Determines if code coverage is running.
     *
     * @return bool
     *   True if code coverage is running, false if not.
     */
    public static function isCoverageOn()
    {
        if (empty(self::SQLITE_DB) || !file_exists(self::SQLITE_DB)) {
            trigger_error('No coverage log');

            return false;
        }

        return true;
    }

    /**
     * @param array $data
     *
     * @return array
     *
     * @since Method available since Release 2.0.0
     */
    private function cleanup(array $data)
    {
        foreach (array_keys($data) as $file) {
            unset($data[$file][0]);

            if ($file != 'xdebug://debug-eval' && file_exists($file)) {
                $numLines = $this->getNumberOfLinesInFile($file);

                foreach (array_keys($data[$file]) as $line) {
                    if ($line > $numLines) {
                        unset($data[$file][$line]);
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @param string $file
     *
     * @return int
     *
     * @since Method available since Release 2.0.0
     */
    private function getNumberOfLinesInFile($file)
    {
        $buffer = file_get_contents($file);
        $lines  = substr_count($buffer, "\n");

        if (substr($buffer, -1) !== "\n") {
            $lines++;
        }

        return $lines;
    }
}
