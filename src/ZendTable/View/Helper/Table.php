<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 18:23
 */

namespace ZendTable\View\Helper;


use ZendTable\TableInterface;

class Table extends AbstractHelper
{
    public function __invoke(TableInterface $table = null)
    {
        if (!$table) {
            return $this;
        }

        return $this->render($table);
    }

    public function render(TableInterface $table)
    {
        $tableContent = '';

        $tableContent .= $this->getView()->tableHead();

        return $tableContent;
    }

    /**
     * @param TableInterface $table
     * @return string
     */
    public function openTag(TableInterface $table)
    {
        $tag = sprintf('<table%s>', $this->createAttributesString($table->getAttributes()));

        return $tag;
    }

    /**
     * @return string
     */
    public function closeTag()
    {
        return '</table>';
    }
}
