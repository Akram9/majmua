Majmua's frontend is made using the Yii2 framework.<br>
Go through the Yii guide - https://www.yiiframework.com/doc/guide/2.0/en/intro-yii - to get started.<br>
This guide - https://www.yiiframework.com/doc/guide/2.0/en/start-installation - is helpful for installation of required software.

The database used is MySQL, although MariaDB should work fine.<br>
To connect to database, change the parameters in main/config/web.php as required.<br>
Manticore search -https://manticoresearch.com - is being used for indexing and searching through the database.<br>
Sphinx search 3 - http://sphinxsearch.com - was being used, and can still be interchangably used without any change in the code.

The crawler used is a PHP script.
The crawler needs to be changed to a Scrapy based one.
To use the current crawler, it needs to be connected to the database.
Change the parameters in the crawler/crawler.php file.
