<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 07/03/14
 * Time: 19:33
 */

namespace SuchTable\View\Helper;


use SuchTable\Element\AbstractList;

abstract class TableAbstractList extends AbstractHelper
{
    protected $tag = 'ul';

    /**
     * @param AbstractList $element
     * @return $this|string
     */
    public function __invoke(AbstractList $element = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * @param AbstractList $element
     * @return string
     */
    public function render(AbstractList $element)
    {
        $value = $element->getValue();
        if (count($value) > 0) {
            $content = '';
            foreach ($value as $v) {
                $content .= "<li>$v</li>";
            }

            return sprintf(
                '<%s %s>%s</%s>',
                $this->getTag(),
                $this->createAttributesString($element->getAttributes()),
                $content,
                $this->getTag()
            );
        }
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }
}
