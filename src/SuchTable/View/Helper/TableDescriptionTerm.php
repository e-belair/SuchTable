<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 12/03/14
 * Time: 13:26
 */

namespace SuchTable\View\Helper;


use SuchTable\Element\DescriptionTerm;

class TableDescriptionTerm extends AbstractHelper
{
    /**
     * @param DescriptionTerm $element
     * @return $this|string
     */
    public function __invoke(DescriptionTerm $element = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * @param DescriptionTerm $element
     * @return string
     */
    public function render(DescriptionTerm $element)
    {
        $data = $element->getData();
        if ($separator = $element->getOption('separator')) {
            $data .= $separator;
        }

        return sprintf(
            '<dt %s>%s</dt>',
            $this->createAttributesString($element->getAttributes()),
            $data
        );
    }
}
