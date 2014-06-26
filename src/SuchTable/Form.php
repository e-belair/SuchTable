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

        $this->add(new ParamsFieldset($table));
        $this->add(new ElementFieldset($table));

        $this->add([
            'name' => 'submit-form',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'ok'
            ]
        ]);
    }
}
