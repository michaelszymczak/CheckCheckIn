CheckCheckIn
============

[![Build Status](https://travis-ci.org/michaelszymczak/CheckCheckIn.svg?branch=master)](https://travis-ci.org/michaelszymczak/CheckCheckIn)

Description
-----------
Simple, language-agnostic, customizable app that helps developers validate modified files (using static code analysis tools etc.).
Can be easily integrated with a git as a pre-commit hook.

Requirements
------------

- Linux shell (e.g. bash)
- Git
- PHP 5.3 and above

Installation
-----------
Use the composer to install the project as a dev dependency and copy the example script:

    cd YOUR_PROJECT_DIRECTORY
    curl -sS https://getcomposer.org/installer | php
    php composer.phar require "michaelszymczak/check-check-in 1.*@dev" --dev

    cp vendor/michaelszymczak/check-check-in/pre-commit.sample pre-commit


Usage
------------
The tool works only inside git repositories. If you don't have one, you can easily create it in the current project's directory:

    git init .

**Edit the pre-commit file and modify the existing template** by configuring paths to code analysis tools of your choice.
The syntax is quite simple - #### is always replaced by the file path. Given foo.php and path/to/bar.php are modified and the tool is configured as follows:

    'PHP Lint' => 'php -l ####'

When you run the script

    ./pre-commit --modified

Then the validator runs `php -l foo.php` and `php -l path/to/bar.php`, print violations and a summary screen.


Integration with git
-------------
You can easily register this tool as the git pre-commit hook:

    cp pre-commit .git/hooks/pre-commit

Remember that the content of the target pre-commit file will be overwritten, so check if it file already exists. From now on, each time you try
to commit some files the tool checks them and rejects the commit if the rules violation has been found.


