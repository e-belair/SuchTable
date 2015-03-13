# SuchTable
[![Master Branch Build Status](https://travis-ci.org/manuscle/SuchTable.svg?branch=master)](https://travis-ci.org/manuscle/SuchTable)
[![Latest Stable Version](https://poser.pugx.org/manuscle/such-table/v/stable.png)](https://packagist.org/packages/manuscle/such-table)
[![Coverage Status](https://img.shields.io/coveralls/manuscle/SuchTable.svg)](https://coveralls.io/r/manuscle/SuchTable)
[![Latest Unstable Version](https://poser.pugx.org/manuscle/such-table/v/unstable.png)](https://packagist.org/packages/manuscle/such-table)

This module provide tools to generate an Html table from various type of data.   
It's work with array or doctrine result.   
This module doesn't have direct interaction with database.   
It's work with table elements (like zend form do with form elements).   
You can work with Entity during the table generation.   

You can help, contact me on IRC #zftalk.dev channel or #zftalk-fr

## Installation

```bash
./composer.phar require manuscle/such-table
#when asked for version, type "dev-master"
```

Enable the module into application.config.php

```php
return array(
    'modules' => array(
        'SuchTable',
        'Application',
        /** ../.. **/
    ),
);
```

Go to the example page http://your_web_project/suchTable

## Example

@see the Wiki pages!
Or you can see some examples since v1.0.3 inside src/SuchTable/Example folder

Example of result:
![Employee list](https://raw.githubusercontent.com/manuscle/SuchTable/master/data/employee-list.png "Example of table generated with joinned table")
