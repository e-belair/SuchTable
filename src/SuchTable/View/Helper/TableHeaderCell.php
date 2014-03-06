<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 18:34
 */

namespace SuchTable\View\Helper;


use SuchTable\ElementInterface;

class TableHeaderCell extends AbstractHelper
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
        return $this->openTag($element) . $element->getLabel() . $this->closeTag();
    }

    /**
     * @param ElementInterface $element
     * @return string
     */
    public function openTag(ElementInterface $element)
    {
        return sprintf('<th %s>', $this->createAttributesString($element->getLabelAttributes()));
    }

    /**
     * @return string
     */
    public function closeTag()
    {
        return '</th>';
    }
}
