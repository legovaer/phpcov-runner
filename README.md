# phpcov-runner

**phpcov-runner** is a command-line tool which allows you to analyse multiple PHP files using
[PHPCOV](https://github.com/sebastianbergmann/phpcov).

## Installation

### Composer

Simply add a dependency on `legovaer/phpcov-runner` to your project's `composer.json` file if you use
[Composer](http://getcomposer.org/) to manage the dependencies of your project. Here is a minimal example of a
`composer.json` file that just defines a development-time dependency on PHPCOV-Runner:

```
{
    "require-dev": {
        "legovaer/phpcov-runner": "*"
    }
}
```

For a system-wide installation via Composer, you can run:

```
composer global require 'legovaer/phpcov-runner=*'
```

Make sure you have `~/.composer/vendor/bin/ in your path.

## Usage

### Start runner

In order to start the PHPCOVRunner, the only command you need to execute is:

```
$ phpcovrunner start
```

### Analysing PHP files

In order to allow PHP files getting analysed, you will need to add three lines to the top of the PHP script:

#### When using the global application

```
$path = $HOME . '/.composer/vendor/legovaer/phpcov-runner/lib";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
require "autocoverage.php";
```

#### When using the application as a local dependency
 
```
$path = __DIR__ . '/vendor/legovaer/phpcov-runner/lib";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
require "autocoverage.php";
```

### Stop runner & generate report

In order to stop the PHPCOVRunner, you will need to execute:

```
$ phpcovrunner stop
```

More information about formatting the report can be found on the official page of
[PHPCOV](https://github.com/sebastianbergmann/phpcov).
