<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 18:34
 */

namespace SuchTable\View\Helper;


use SuchTable\ElementInterface;
use SuchTable\Exception\InvalidArgumentException;
use SuchTable\Exception\InvalidElementException;
use SuchTable\TableInterface;

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
     * @todo attributes ?
     *
     * @return string
     */
    public function openTag()
    {
        return '<tr>';
    }

    /**
     * @return string
     */
    public function closeTag()
    {
        return '</tr>';
    }
}
