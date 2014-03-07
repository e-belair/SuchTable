<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 18:35
 */

namespace SuchTable\View\Helper;


use SuchTable\TableInterface;

class TableHead extends AbstractHelper
{
    protected $tag = 'thead';

    /**
     * @param TableInterface $table
     * @return TableHead|string
     */
    public function __invoke(TableInterface $table = null)
    {
        if (!$table) {
            return $this;
        }

        return $this->render($table);
    }

    /**
     * @param TableInterface $table
     * @return string
     */
    public function render(TableInterface $table)
    {
        /** @var TableRow $tr */
        $tr = $this->getView()->plugin('tr');
        /** @var TableHeaderCell $th */
        $th = $this->getView()->plugin('th');

        $content = '';
        foreach ($table as $element) {
            $content .= $th->render($element);
        }
        if ($content) {
            return $this->openTag() . $tr->openTag() . $content . $tr->closeTag() . $this->closeTag();
        }
    }

    /**
     * @todo attributes ?
     * @return string
     */
    public function openTag()
    {
        return '<thead>';
    }

    public function closeTag()
    {
        return '</thead>';
    }
}
