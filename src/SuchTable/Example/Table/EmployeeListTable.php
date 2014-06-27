<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 27/06/14
 * Time: 17:18
 */

namespace SuchTable\Example\Table;


use SuchTable\Element\DescriptionDesc;
use SuchTable\Element\DescriptionList;
use SuchTable\Element\DescriptionTerm;
use SuchTable\Table;

class EmployeeListTable extends Table
{
    public function __construct($name = 'employee-list', $options = array())
    {
        parent::__construct($name, $options);

        //$this->setOption('disableForm', true);

        $this->add([
            'name' => 'id',
            'type' => 'SuchTable\Element\Text',
            'options' => [
                'label' => 'ID'
            ]
        ]);

        $this->add([
            'name' => 'firstName',
            'type' => 'SuchTable\Element\Text',
            'options' => [
                'label' => 'Firstname'
            ]
        ]);

        $this->add([
            'name' => 'lastName',
            'type' => 'SuchTable\Element\Text',
            'options' => [
                'label' => 'Lastname'
            ]
        ]);

        $attrList = new DescriptionList('titles', ['label' => 'Titles']);
        $attrList->setAttributes([
            'class' => 'dl-horizontal',
            'style' => 'margin:0;'
        ])
            ->setOption('disableForm', true)
            ->setOption('disableOrderBy', true);

        $dt = new DescriptionTerm('title', ['separator' => ' :']);

        $attrList->add($dt)
            ->add(new DescriptionDesc('fromDate'));
        $this->add($attrList);
    }
}
