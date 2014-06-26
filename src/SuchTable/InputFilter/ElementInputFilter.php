<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 26/06/14
 * Time: 15:21
 */

namespace SuchTable\InputFilter;


use SuchTable\ElementInterface;
use Zend\InputFilter\InputFilter;

class ElementInputFilter extends InputFilter
{
    public function addTableElement(ElementInterface $element)
    {
        $this->add([
            'name' => $element->getName(),
            'required' => false,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 100,
                    ),
                ),
            ),
        ]);
    }
}
