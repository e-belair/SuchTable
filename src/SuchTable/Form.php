<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 14/03/14
 * Time: 16:22
 */

namespace SuchTable;


use Zend\Form\Fieldset;

class Form extends \Zend\Form\Form
{
    /**
     * @var Table
     */
    protected $table;

    public function __construct(Table $table, $options = array())
    {
        $name = $table->getName() . '-form';
        parent::__construct($name, $options);

        $paramsFieldset = new Fieldset($table->getName() . '-params');

        if ($table->getOption('disablePaginationHandler') !== true) {
            $paramsFieldset->add([
                'name' => 'page',
                'type' => 'hidden'
            ]);
        }

        $paramsFieldset->add([
            'name' => 'order',
            'type' => 'hidden'
        ]);

        $paramsFieldset->add([
            'name' => 'way',
            'type' => 'hidden'
        ]);

        $this->add($paramsFieldset);

        // Fieldset elements
        $elementsFieldset = new Fieldset($table->getName() . '-elements');
        /** @var Element $element */
        foreach ($table as $element) {
            if ($element->getOption('disableForm') !== true) {
                $elementsFieldset->add([
                    'name' => $element->getName(),
                    'type' => 'Text',
                    'options' => [
                        'label' => $element->getLabel()
                    ]
                ]);
            }
        }

        $this->add([
            'name' => 'submit-form',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'ok'
            ]
        ]);
    }
}
