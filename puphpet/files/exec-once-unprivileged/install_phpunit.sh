#!/bin/bash

# install PHPUnit and Selenium dependencies
# see: http://saa.dfarooq.com/blog/2014/01/10/phpunit-with-yii-and-composer/
composer global require "phpunit/phpunit:3.7.*"
composer global require 'phpunit/phpunit-selenium:>=1.2'
composer global require 'phpunit/phpunit-story'
composer global require 'phpunit/dbunit:>=1.2'
composer global require 'phpunit/php-invoker'

# for some reason adding to PATH here isn't working, so I moved this to .bash_profile
#export PATH=$PATH:$HOME/.config/composer/vendor/bin