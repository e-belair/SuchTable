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
     * @param $type
     * @return mixed
     */
    public function setType($type);

    /**
     * @return string
     */
    public function getType();

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
     * @param TableInterface $table
     * @return ElementInterface
     */
    public function setTable(TableInterface $table);

    /**
     * @return TableInterface
     */
    public function getTable();

    /**
     * @param BaseInterface $parent
     * @return ElementInterface
     */
    public function setParent($parent);

    /**
     * @return BaseInterface
     */
    public function getParent();
}
