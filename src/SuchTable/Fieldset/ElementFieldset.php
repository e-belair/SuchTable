<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 25/06/14
 * Time: 20:01
 */

namespace SuchTable\Fieldset;


use SuchTable\Element;
use SuchTable\ElementInterface;
use SuchTable\Table;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class ElementFieldset extends Fieldset
{
    public function __construct(Table $table, $options = array())
    {
        $this->table = $table;
        parent::__construct($table->getElementsKey(), $options);
    }

    public function addTableElement(ElementInterface $element)
    {
        $this->add([
            'name' => $element->getName(),
            'type' => 'Text',
            'options' => [
                'label' => $element->getLabel()
            ]
        ]);
    }
}
