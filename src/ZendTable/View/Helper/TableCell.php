<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 18:34
 */

namespace ZendTable\View\Helper;


use ZendTable\ElementInterface;

class TableCell extends AbstractHelper
{
    public function __invoke(ElementInterface $element)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * @param ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        return $this->openTag($element) . $element->getValue() . $this->closeTag();
    }

    /**
     * @param ElementInterface $element
     * @return string
     */
    public function openTag(ElementInterface $element)
    {
        return sprintf('<td %s>', $this->createAttributesString($element->getAttributes()));
    }

    /**
     * @return string
     */
    public function closeTag()
    {
        return '</td>';
    }
}
