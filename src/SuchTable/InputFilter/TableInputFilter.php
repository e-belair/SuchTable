<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 26/06/14
 * Time: 15:23
 */

namespace SuchTable\InputFilter;


use SuchTable\Table;
use Zend\InputFilter\InputFilter;

class TableInputFilter extends InputFilter
{
    public function __construct(Table $table)
    {
        $this->add(new ParamsInputFilter($table), $table->getParamsKey());
        $this->add(new ElementInputFilter($table), $table->getElementsKey());
    }
}
