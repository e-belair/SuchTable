<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 12/03/14
 * Time: 16:18
 */

namespace SuchTable\View\Helper;


use SuchTable\Element\ListItem;

class TableListItem extends AbstractHelper
{
    /**
     * @param ListItem $element
     * @return $this|string
     */
    public function __invoke(ListItem $element = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * @param ListItem $element
     * @return string
     */
    public function render(ListItem $element)
    {
        return sprintf(
            '<li %s>%s</li>',
            $this->createAttributesString($element->getAttributes()),
            $element->getData()
        );
    }
}
