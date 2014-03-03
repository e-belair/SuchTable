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

        $tableContent .= $this->getView()->thead($table)
                       . $this->getView()->tbody($table);

        return $this->openTag($table) . $tableContent . $this->closeTag();
    }

    /**
     * @param TableInterface $table
     * @return string
     */
    public function openTag(TableInterface $table)
    {
        $attributes = $table->getAttributes();
        if (!array_key_exists('id', $attributes)) {
            $attributes['id'] = $table->getName();
        }

        $tag = sprintf('<table %s>', $this->createAttributesString($attributes));

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
