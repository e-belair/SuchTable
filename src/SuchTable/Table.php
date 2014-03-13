<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 16:17
 */

namespace SuchTable;


use Zend\Form\FormInterface;
use Zend\Stdlib\PriorityQueue;

class Table extends BaseElement implements TableInterface
{
    protected $attributes = array(
        'class' => 'table table-bordered table-striped'
    );

    /**
     * @var FormInterface
     */
    protected $form;
}
