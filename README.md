# Social Stats

_Social network services stats. API independant._

Current Version: **0.4.1**

![Social Stats 0.4](http://imgs.be/513361fd-12dc.png)

## Requirements

* PHP (cURL)
* cron
* [DYGraphs](https://github.com/danvk/dygraphs)
* [jQuery](https://github.com/jquery/jquery)

## Installation instructions

1. rename the `config.example.php` file into `config.php`
2. add your information in the `config.php` file:

        $accounts = array(
          // one account = one array
          array(
            'title'    => '', // i.e. Account Title
            'twitter'  => '', // i.e. your_account
            'identica' => '', // i.e. your_account
            'facebook' => '', // i.e. https://facebook.com/pages/0123456789
          ),
        );

3. upload the `social-stats/` folder on your webserver
4. add the following rule to your crontab for each `account`:

        0 0,6,12,18 * * * wget -q -O "/dev/null" "http://domain.tld/path/to/social-stats/?update&id=account"

5. profit

## Licence

Copyright &copy; 2013- André LOCONTE

This program is free software: you can redistribute it and/or modify it under the terms of the [GNU Affero General Public License](https://gnu.org/licenses/agpl.html) as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.