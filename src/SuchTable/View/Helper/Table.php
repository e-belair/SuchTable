<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 18:23
 */

namespace SuchTable\View\Helper;


use SuchTable\TableInterface;

class Table extends AbstractHelper
{
    public function __invoke(TableInterface $table = null)
    {
        if (!$table) {
            return $this;
        }

        return $this->render($table);
    }

    /**
     * @todo implement tfoot
     *
     * @param TableInterface $table
     * @return string
     */
    public function render(TableInterface $table)
    {
        /** @var TableHead $thead */
        $thead = $this->getView()->plugin('thead');
        /** @var TableBody $tbody */
        $tbody = $this->getView()->plugin('tbody');

        $tableContent = $thead->render($table) . $tbody->render($table);

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
