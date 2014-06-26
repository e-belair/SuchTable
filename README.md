# SuchTable
[![Latest Unstable Version](https://poser.pugx.org/manuscle/such-table/v/unstable.png)](//packagist.org/packages/manuscle/such-table)

This module provide tools to generate an Html table from various type of data.

This module is under development.
It's work with array or doctrine result.

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

    $attrList = new DescriptionList('attributes');
    $attrList->setAttributes([
        'class' => 'dl-horizontal',
        'style' => 'margin:0;'
    ]);
    $attrList->add(new DescriptionTerm('name'), ['separator' => ' :'])
        ->add(new DescriptionDesc('value'));
    $table->add($attrList);

    // OR
    // $ul = new UnorderedList('attributes');
    // $ul->add(new ListItem('value'));
    // $table->add($ul);

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

    return new ViewModel([
        'table' => $table
    ]);
}
```

From the view

```php
echo $this->table($this->table);
```

## Same example with doctrine result

Just change the link element to work with object

```php
    $table->add([
        'name' => 'link',
        'type' => 'SuchTable\Element\Link',
        'options' => [
            'innerHtml' => function (Link $element) {
                $text = 'Add to cart';
                if ($element->getRowData()->getStock() < 6) {
                    $text .= ' ('.$element->getRowData()->getStock() . ' in stock!)';
                }
                return $text;
            }
        ],
        'attributes' => [
            'href' => function (Link $element) {
                return '#?id=' . $element->getRowData()->getId();
            },
            'class' => function (Link $element) {
                return 'btn btn-' . ($element->getRowData()->getStock() < 6 ? 'warning' : 'primary') ;
            },
            'target' => '_blank'
        ]
    ]);
```

Then make a query like this:

```php

    /** @var EntityManager $em */
    $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    $products = $em->createQueryBuilder()
        ->select('p', 'a')
        ->from('Application\Entity\Product', 'p')
        ->leftJoin('p.attributes', 'a')
        ->getQuery()
        ->getResult();

    $table->setData($products);
```

## Parameters, pagination and form

The table contain a form to embed the parameters such as search on fields or pagination or order by.
You can add this code inside the controller to get it working:

```php
    // Set the defaults
    $params = [
        'order' => 'id',
        'way' => 'ASC',
        'page' => 1,
        'itemsPerPage' => 30
    ];
    $table->setParams($params);
    
    $request = $this->getRequest();
    if ($request->isPost()) {
        $table->setParams((array) $request->getPost());
    }
    
    // Update the query
    $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    $qb = $em->createQueryBuilder()
        ->select('p', 'a')
        ->from('Application\Entity\Product', 'p')
        ->leftJoin('p.attributes', 'a')
        ->orderBy('e.'.$table->getParam('order'), $table->getParam('way'));

    if ($designation = $table->getParam('designation')) {
        $qb->where($qb->expr()->like('p.designation', $qb->expr()->literal("%{$designation}%")));
    }
    
    $products = new Paginator(new DoctrinePaginator(new \Doctrine\ORM\Tools\Pagination\Paginator($qb)));
    $products->setCurrentPageNumber($table->getParam('page'));
    $table->setData($products)
        ->getPaginator()
        ->setItemCountPerPage($table->getParam('itemsPerPage'))
        ->setCurrentPageNumber($table->getParam('page'));
```

Then in the view script:

```php
echo $this->table($table);

echo $this->paginationControl(
    $table->getPaginator(),
    'Sliding',
    'such-table/paginationcontrol',
    ['table' => $table]
);
```