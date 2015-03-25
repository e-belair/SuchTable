<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 12/03/14
 * Time: 13:26
 */

namespace SuchTable\View\Helper;

use SuchTable\Element\DescriptionDesc;

class TableDescriptionDesc extends AbstractHelper
{
    /**
     * @param DescriptionDesc $element
     * @return $this|string
     */
    public function __invoke(DescriptionDesc $element = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * @param DescriptionDesc $element
     * @return string
     */
    public function render(DescriptionDesc $element)
    {
        return sprintf(
            '<dd %s>%s</dd>',
            $this->createAttributesString($element->getAttributes()),
            $element->getData()
        );
    }
}
