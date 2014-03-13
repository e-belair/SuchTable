<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 07/03/14
 * Time: 17:06
 */

namespace SuchTable\View\Helper;


use SuchTable\Element\DescriptionList;
use SuchTable\Element;

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
        /** @var TableDescriptionTerm $dt */
        $dt = $this->getView()->plugin('tableDescriptionTerm');
        /** @var TableDescriptionDesc $dd */
        $dd = $this->getView()->plugin('tableDescriptionDesc');

        $content = '';
        foreach ($element->getRows() as $row) {
            /** @var Element $el */
            foreach ($row as $el) {
                if ($el->getType() == 'descriptionTerm') {
                    $content .= $dt->render($el);
                } elseif ($el->getType() == 'descriptionDesc') {
                    $content .= $dd->render($el);
                }
            }
        }

        if ($content) {
            return sprintf('<dl %s>%s</dl>', $this->createAttributesString($element->getAttributes()), $content);
        }
    }
}
