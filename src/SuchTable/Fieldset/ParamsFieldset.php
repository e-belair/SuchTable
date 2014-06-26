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

class ParamsFieldset extends Fieldset
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

        $this->add([
            'name' => 'page',
            'type' => 'hidden'
        ]);
    }
}
