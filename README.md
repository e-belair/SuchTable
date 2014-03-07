# SuchTable
[![Latest Unstable Version](https://poser.pugx.org/manuscle/such-table/v/unstable.png)](//packagist.org/packages/manuscle/such-table)

This module provide tools to generate an Html table from various type of data.

This module is under development.
It's work with array or doctrine result.

TODO: pagination
TODO: Embed order by
TODO: Embed Search Form

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

## Example

Into a controller or whenever you want:

```php
public function indexAction()
{
    $table = new Table('product-list');

    $table->add([
        'name' => 'id',
        'type' => 'SuchTable\Element\Text',
        'options' => [
            'label' => 'Identifiant'
        ]
    ]);

    $table->add([
        'name' => 'designation',
        'type' => 'SuchTable\Element\Text',
        'options' => [
            'label' => 'Désignation'
        ]
    ]);

    $table->add([
        'name' => 'attributes',
        'type' => 'SuchTable\Element\DescriptionList',
        'options' => [
            // Key or property for the dt tag
            'dtGetter' => 'name',
            // Key or property for the dd tag
            'ddGetter' => 'value',
            // the string will be added at the end of dt tag content (optional)
            'separator' => ' :',
            'label' => 'Attributes'
        ],
        'attributes' => [
            'class' => 'dl-horizontal',
            'style' => 'margin:0;'
        ]
    ]);

    $table->add([
        'name' => 'link',
        'type' => 'SuchTable\Element\Link',
        'options' => [
            'innerHtml' => function (Link $element) {
                $text = 'Add to cart';
                if ($element->getRowData()['stock'] < 6) {
                    $text .= ' ('.$element->getRowData()['stock'] . ' in stock!)';
                }
                return $text;
            }
        ],
        'attributes' => [
            'href' => function (Link $element) {
                return '#?id=' . $element->getRowData()['id'];
            },
            'class' => 'btn btn-primary'
        ]
    ]);

    $table->setData([
        [
            'id' => 1, 'designation' => 'Fender stratocaster vintage', 'stock' => 5,
            'attributes' => [
                ['id' => 1, 'name' => 'Color', 'value' => 'sunburst'],
                ['id' => 2, 'name' => 'Body Material', 'value' => 'Alder'],
                ['id' => 3, 'name' => 'Neck Finish', 'value' => 'Fender Flash Coat Lacquer'],
            ]
        ],
        ['id' => 2, 'designation' => 'Ibanez Pat Metheny', 'stock' => 10],
        ['id' => 3, 'designation' => 'Gibson Les Paul', 'stock' => 15],
        ['id' => 4, 'designation' => 'Music Man Luke', 'stock' => 2],
    ]);
}
```

From the view

```php
echo $this->table($this->table);
```


