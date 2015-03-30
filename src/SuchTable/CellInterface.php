<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 17:04
 */

namespace SuchTable;

interface CellInterface extends BaseInterface
{
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
}
