# Social Stats

_Social stats is a handy tool that logs stats from various social networks and displays it in an ergonomic web interface. It is API-independant which means that you can gather information about any account, don't need to provide credentials and won't have to deal with API updates and/or restrictions._

Current Version: **0.5.0.3**

![Social Stats 0.5](http://imgs.be/5152ffdc-1517.png)

## Features

### Information from the following social networks:

* Twitter (followers, tweets)
* Identica (followers, notices)
* Facebook pages (likes)

### Dynamic graphs

Graphs can be zoomed in/out around specific values and/or periods.

### Interoperable log format

Social stats generates two types of CSV log:

* The **raw log** provides detailed information about every attempt to collect data and whether it worked or not
* The **clean log** is used to generate graphs and can easily be imported in any application

## Requirements

* PHP
* [PHP cURL library](http://php.net/manual/en/book.curl.php)
* cron
* [DYGraphs](https://github.com/danvk/dygraphs) (included)
* [jQuery](https://github.com/jquery/jquery) (included)

## Installation instructions

1. Clone the repository to your web server

        git clone https://github.com/alct/social-stats.git

2. Rename `config.example.php` into `config.php`
3. Add your information in `config.php`
4. Add the following rule to your crontab

        0 0,6,12,18 * * * wget -q -O "/dev/null" "http://domain.tld/path/to/social-stats/?update"

5. Profit

## Licence

Copyright &copy; 2013- André LOCONTE

This program is free software: you can redistribute it and/or modify it under the terms of the [GNU Affero General Public License](https://gnu.org/licenses/agpl.html) as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.