<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 18:34
 */

namespace SuchTable\View\Helper;

class TableRow extends AbstractHelper
{
    /**
     * @return TableRow
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @param array $attributes
     * @return string
     */
    public function openTag(array $attributes = array())
    {
        return sprintf('<tr %s>', $this->createAttributesString($attributes));
    }

    /**
     * @return string
     */
    public function closeTag()
    {
        return '</tr>';
    }
}
