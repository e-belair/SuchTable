# ZendTable
_Short description_

This module provide tools to generate an Html table from various type of data.

This module is under development and not finished yet.
For instance, the module work with array and there is not order filter available ...

You can help, contact me on IRC #zftalk.dev channel or #zftalk-fr

## Installation

```bash
./composer.phar require manuscle/zend-table
#when asked for version, type "dev-master"
```

Enable the module into application.config.php

```php
return array(
    'modules' => array(
        'ZendTable',
        'Application',
        /** ../.. **/
    ),
);
```

## Example

Into a controller or whenever you want:

```php
public function indexAction()
{
    $table = new Table('product-list');

    $table->add([
        'name' => 'id',
        'type' => 'ZendTable\Element\Text',
        'options' => [
            'label' => 'Identifiant'
        ]
    ]);

    $table->add([
        'name' => 'designation',
        'type' => 'ZendTable\Element\Text',
        'options' => [
            'label' => 'Désignation'
        ]
    ]);

    $table->setData([
        ['id' => 1, 'designation' => 'Fender stratocaster vintage'],
        ['id' => 2, 'designation' => 'Ibanez Pat Metheny'],
        ['id' => 3, 'designation' => 'Gibson Les Paul'],
        ['id' => 4, 'designation' => 'Music Man Luke'],
    ]);

    return new ViewModel([
        'table' => $table
    ]);
}
```

From the view

```php
echo $this->table($this->table);
```


