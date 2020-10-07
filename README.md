# Majmua

The front end of Majmua is built on top the Yii2 framework.<br>
The backend uses MariaDB and ManticoreSearch.
The crawler, which is yet to be added, is a Scrapy based crawler.

## Get started
To get started, fork the repo to your Github account.<br>
Then clone the forked repo to your local development space.<br>
It is suggested that you use a Unix-like OS (Linux based or OSX) to develop.
Alternately you can develop on Windows 10 using WSL or by installing a Linux based OS onVirtualMachine.

## Crawler
If you wish to work on the crawler, ensure that you have Python 3 (>=3.5) is installed.<br>
The crawler code will be in the `crawler` directory. Once the crawler is added, the instructions will be added here.<br>
<br>
<br>
## Frontend
To work on the frontend as well as backend, install the following - 
* PHP 7 - https://www.php.net/manual/en/install.php 
* Composer - https://getcomposer.org/doc/00-intro.md
<br>
Test the application by running the following - 

    cd <directory where cloned>/main
    composer install
    php yii serve --port=8000

You may get errors while doing `composer install` regarding missing `mbstring` dependencies. For this you need to install the `php-mbstring` package using your package manager like - `sudo apt-get install php-mbstring`.<br>
<br>
Also, ensure that port 8000 is empty. Or you may change the port to some other number and run the command.<br>
Then in the browser try http://localhost:8000 or whatever port number you have chosen.<br>
<br>
It is suggested to read the Yii2 docs for  better understanding - https://www.yiiframework.com/doc/guide/2.0/en/intro-yii.<br>
The application style is that of the `Basic Application` on Yii2 giuide.
<br>

# Backend
To work on the backend, you need to additionally install the following -
* MariaDB - https://mariadb.com/kb/en/getting-installing-and-upgrading-mariadb/ or for linux - https://downloads.mariadb.org/mariadb/repositories/
* Manticore Search - https://manual.manticoresearch.com/Installation
<br>
Then create a database with `utf8mb4` charset and `utf8mb4_unicode_ci` collation in MariaDB -<br>

```CREATE DATABASE mydatabase CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;```
<br>
And import the example sql-dump to the database. (link to be added)<br>
<br>
Connect the application to MariaDB by changing the parameters in `main/config/db.php`.<br>
<br>
To connect Manticore Search, copy the config file `config-files/manticore.conf` to the correct place. In Ubuntu, it is `/etc/manticoresearch/manticore.conf`.<br>
Before this, enter the correct parameters in the config file regarding MariaDB - the username, password and database name.<br>
<br>
Run the `searchd` command in the terminal to start the search daemon. You may encounter `file not present errors`.
Creating the required directory should solve the issue.<br>
<br>
The run the indexer `indexer --all --rotate` to index the database's contents.<br>
<br>
It is recommended to go through the Manticore Search docs to work with Manticore Search.<br>
<br>
<br>
## Extras
The database being used initially was MySQL. Although it should work fine even now with no change in code.<br>

Currently, the crawler used is a PHP script.<br>
The crawler needs to be changed to a Scrapy based one.<br>
To use the current crawler, it needs to be connected to the database.<br>
Change the parameters in the crawler/crawler.php file.
