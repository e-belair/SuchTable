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
use SuchTable\TableInterface;

class TableRow extends AbstractHelper
{
    /**
     * @todo setData should be made into a prepare data or populate inside table
     *
     * @param string $rowGroup
     * @param TableInterface $table
     * @param null $rowData
     * @return $this|string
     * @throws \SuchTable\Exception\InvalidArgumentException
     */
    public function __invoke($rowGroup = 'tbody', TableInterface $table = null, $rowData = null)
    {
        if (!$table) {
            return $this;
        }

        $content = '';
        switch ($rowGroup) {
            case 'thead':
                $helper = $this->getView()->plugin('th');
                /** @var ElementInterface $element */
                foreach ($table as $element) {
                    $content .= $helper->render($element);
                }
                break;
            case 'tbody':
                $helper = $this->getView()->plugin('td');
                /** @var ElementInterface $element */
                foreach ($table as $element) {

                    $element->setTable($table)->setRowData($rowData);

                    if (isset($rowData[$element->getName()])) {
                        $element->setData($rowData[$element->getName()]);
                    }

                    $content .= $helper->render($element);
                }
                break;
            case 'tfoot':
                // @todo implement tfoot
                break;
            default:
                throw new InvalidArgumentException("Invalid rowGroup provided");
        }

        return $this->openTag($table) . $content . $this->closeTag();
    }

    /**
     * @todo attributes ?
     *
     * @param TableInterface $table
     * @return string
     */
    public function openTag(TableInterface $table)
    {
        return '<tr>';
    }

    public function closeTag()
    {
        return '</tr>';
    }
}
