<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 25/06/14
 * Time: 20:01
 */

namespace SuchTable\Fieldset;


use SuchTable\Element;
use SuchTable\Table;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class ElementFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(Table $table, $options = array())
    {
        $this->table = $table;

        parent::__construct($table->getElementsKey(), $options);

        /** @var Element $element */
        foreach ($this->table as $element) {
            if ($element->getOption('disableForm') !== true) {
                $this->add([
                    'name' => $element->getName(),
                    'type' => 'Text',
                    'options' => [
                        'label' => $element->getLabel()
                    ]
                ]);
            }
        }
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        $inputFilter = [];
        /** @var Element $element */
        foreach ($this->table as $element) {
            if ($element->getOption('disableForm') !== true) {
                $inputFilter[$element->getName()] = [
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
                ];
            }
        }

        return $inputFilter;
    }
}
