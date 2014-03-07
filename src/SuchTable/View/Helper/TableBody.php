<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 18:35
 */

namespace SuchTable\View\Helper;


use SuchTable\TableInterface;

class TableBody extends AbstractHelper
{
    protected $tag = 'tbody';

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
        /** @var TableCell $td */
        $td = $this->getView()->plugin('td');

        $content = '';
        foreach ($table->getRows() as $row) {
            $lineContent = '';
            foreach ($row as $element) {
                $lineContent .= $td->render($element);
            }
            if ($lineContent) {
                $content .= $tr->openTag() . $lineContent . $tr->closeTag();
            }
        }
        if ($content) {
            return $this->openTag() . $content . $this->closeTag();
        }
    }

    /**
     * @todo attributes ?
     * @return string
     */
    public function openTag()
    {
        return '<tbody>';
    }

    /**
     * @return string
     */
    public function closeTag()
    {
        return '</tbody>';
    }
}
