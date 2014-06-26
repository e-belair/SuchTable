<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 25/06/14
 * Time: 19:39
 */

namespace SuchTable\Fieldset;


use SuchTable\Table;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class ParamsFieldset extends Fieldset implements InputFilterProviderInterface
{
    /** @var \SuchTable\Table */
    protected $table;

    public function __construct(Table $table, $options = array())
    {
        $this->table = $table;

        $name = $table->getName() . '-params';
        parent::__construct($name, $options);

        $this->add([
            'name' => 'order',
            'type' => 'hidden'
        ]);

        $this->add([
            'name' => 'way',
            'type' => 'hidden'
        ]);

        $this->add([
            'name' => 'itemsPerPage',
            'type' => 'hidden'
        ]);

        if ($table->getOption('disablePaginationHandler') !== true) {
            $this->add([
                'name' => 'page',
                'type' => 'hidden'
            ]);
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
        $elNames = [];
        foreach ($this->table->getElements() as $element) {
            if ($element->getOption('disableOrderBy') !== true) {
                $elNames[] = $element->getName();
            }
        }

        $inputFilter = [
            'way' => [
                'required' => true,
                'validators' => [new \Zend\Validator\InArray(['haystack' => ['ASC', 'DESC']])]
            ],
            'order' => [
                'required' => true,
                'validators' => [new \Zend\Validator\InArray(['haystack' => $elNames])]
            ],
            'itemsPerPage' => [
                'required' => true,
                'filters' => [new \Zend\Filter\Int()]
            ],
        ];

        if ($this->table->getOption('disablePaginationHandler') !== true) {
            $inputFilter['page'] = [
                'required' => true,
                'filters' => [new \Zend\Filter\Int()]
            ];
        }

        return $inputFilter;
    }
}
