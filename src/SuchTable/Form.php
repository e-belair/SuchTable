<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 14/03/14
 * Time: 16:22
 */

namespace SuchTable;


use SuchTable\Fieldset\ElementFieldset;
use SuchTable\Fieldset\ParamsFieldset;
use SuchTable\InputFilter\TableInputFilter;

class Form extends \Zend\Form\Form
{
    /**
     * @var Table
     */
    protected $table;

    public function __construct(Table $table, $options = array())
    {
        $this->table = $table;

        $name = $table->getName() . '-form';
        parent::__construct($name, $options);

        $this->setInputFilter(new TableInputFilter($table));
        $this->add(new ParamsFieldset($table));
        $this->add(new ElementFieldset($table));

        $this->add([
            'name' => 'submit-form',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'ok',
                'style' => 'width: 0px; height:0px; margin: 0; padding: 0; border: 0;'
            ]
        ]);
    }
}
