<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 18:35
 */

namespace SuchTable\View\Helper;


use SuchTable\BaseInterface;
use SuchTable\Element\DataRow;
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
        $content = '';
        foreach ($table->getRows() as $row) {
            foreach ($row as $dataRow) {
                $content .= $this->lineContent($dataRow);
            }
        }

        if ($content) {
            return $this->openTag() . $content . $this->closeTag();
        }
    }

    /**
     * @param DataRow $dataRow
     * @return string
     */
    protected function lineContent(DataRow $dataRow)
    {
        /** @var TableRow $tr */
        $tr = $this->getView()->plugin('tr');
        /** @var TableCell $td */
        $td = $this->getView()->plugin('td');

        $lineContent = '';
        foreach ($dataRow->getRows() as $el) {
            $lineContent .= $td->render($el);
        }

        return $tr->openTag($dataRow->getAttributes()) . $lineContent . $tr->closeTag();
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
