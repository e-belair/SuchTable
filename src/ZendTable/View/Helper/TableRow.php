<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 18:34
 */

namespace ZendTable\View\Helper;


use ZendTable\ElementInterface;
use ZendTable\Exception\InvalidArgumentException;
use ZendTable\TableInterface;

class TableRow extends AbstractHelper
{
    protected $rowGroup;

    public function __invoke($rowGroup = 'tbody', TableInterface $table = null)
    {
        $this->rowGroup = $rowGroup;

        if (!$table) {
            return $this;
        }

        switch ($rowGroup) {
            case 'thead':
                $helper = $this->getView()->tableHeaderCell();
                break;
            case 'tbody':
            case 'tfoot':
                $helper = $this->getView()->tableCell();
                break;
            default:
                throw new InvalidArgumentException("Invalid rowGroup provided");
        }

        $content = '';
        /** @var ElementInterface $element */
        foreach ($table as $element) {
            if ($element->getOption('rowGroup') == $rowGroup) {
                $content .= $helper->render($element);
            }
        }

        return $content;
    }

    /**
     * @todo sttributes
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
