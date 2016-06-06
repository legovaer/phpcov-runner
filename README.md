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

In order to start the PHPCOV-Runner, the only command you need to execut is:

```
$ phpcovrunner start
```
