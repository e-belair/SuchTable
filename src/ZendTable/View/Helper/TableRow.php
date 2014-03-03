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
                foreach ($rowData as $name => $data) {
                    if (!$table->has($name)) {
                        continue;
                    }

                    $element = $table->get($name)->setData($data);
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
