<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 17:04
 */

namespace SuchTable;


interface ElementInterface extends BaseInterface
{
    /**
     * @return ElementInterface
     * @throws Exception\InvalidElementException
     */
    public function prepare();

    /**
     * @param $type
     * @return mixed
     */
    public function setType($type);

    /**
     * @return string
     */
    public function getType();

    /**
     * @param mixed $value
     * @return ElementInterface
     */
    public function setValue($value);

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $label
     * @return ElementInterface
     */
    public function setLabel($label);

    /**
     * @return mixed
     */
    public function getLabel();

    /**
     * @param array $labelAttributes
     * @return ElementInterface
     */
    public function setLabelAttributes(array $labelAttributes);

    /**
     * @return array
     */
    public function getLabelAttributes();

    /**
     * @param $rowData
     * @return ElementInterface
     */
    public function setRowData($rowData);

    /**
     * @return mixed
     */
    public function getRowData();

    /**
     * @param TableInterface $table
     * @return ElementInterface
     */
    public function setTable(TableInterface $table);

    /**
     * @return TableInterface
     */
    public function getTable();
}
