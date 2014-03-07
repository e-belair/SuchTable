<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 07/03/14
 * Time: 17:06
 */

namespace SuchTable\View\Helper;


use SuchTable\Element\DescriptionList;

class TableDescriptionList extends AbstractHelper
{
    /**
     * @param DescriptionList $element
     * @return $this|string
     */
    public function __invoke(DescriptionList $element = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * @param DescriptionList $element
     * @return string
     * @throws \SuchTable\Exception\InvalidArgumentException
     */
    public function render(DescriptionList $element)
    {
        $value = $element->getValue();
        if (count($value) > 0) {
            $content = '';
            foreach ($value as $v) {
                foreach ($v as $dt => $dd) {
                    $content .= "<dt>$dt</dt><dd>$dd</dd>";
                }
            }

            return sprintf('<dl %s>%s</dl>', $this->createAttributesString($element->getAttributes()), $content);
        }
    }
}
