MeterMaid
=========

Collect and display utility consumption data.

## Requirements

  * [PHP](http://php.net) >= 7.0
  * [Composer](https://getcomposer.org)

## Installation

Clone the repository and install dependencies using Composer:

    $ git clone https://github.com/electrickite/metermaid.git
    $ cd metermaid
    $ composer install

Create the database schema:

    $ vendor/bin/phinx migrate

## Use

To run locally with the built-in PHP web server:

    $ php -S localhost:8000 -t public index.php

And then access the application at ex: [http://localhost:8000/verify](http://localhost:8000/verify)

An interactive console can be run in the context of the application with:

    $ php -d auto_prepend_file=src/bootstrap.php -a

### Readings

New meter readings can be taken using the `bin/take_reading` script:

    $ bin/take_reading     # Reads all meters
    $ bin/take_reading 2   # Reads meter ID 2
