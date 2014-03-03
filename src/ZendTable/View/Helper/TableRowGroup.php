<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 19:04
 */

namespace ZendTable\View\Helper;


use ZendTable\ElementInterface;
use ZendTable\Exception\InvalidArgumentException;
use ZendTable\TableInterface;

abstract class TableRowGroup extends AbstractHelper
{
    /**
     * Tag to use for rendering
     *
     * @var string
     */
    protected $tag = '';

    protected $validTags = array(
        'thead',
        'tbody',
        'tfoot'
    );

    /**
     * @param TableInterface $table
     * @return $this
     * @throws \ZendTable\Exception\InvalidArgumentException
     */
    public function __invoke(TableInterface $table = null)
    {
        if (!isset($this->validTags[$this->tag])) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid tag "%s" provided for row Group, expect "%s"',
                    $this->tag,
                    implode(',', $this->validTags)
                )
            );
        }
        if (!$table) {
            return $this;
        }

        return $this->render($table);
    }


    public function render(TableInterface $table)
    {
        $content = '';

        $content .= $this->getView()->tableRow($this->tag, $table);

        if ($content) {
            return $this->openTag() . $content . $this->closeTag();
        }
    }

    /**
     * @todo attributes
     * @return string
     */
    public function openTag()
    {
        return sprintf('<%s>', $this->tag);
    }

    public function closeTag()
    {
        return sprintf('</%s>', $this->tag);
    }
}
