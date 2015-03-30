<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 18:34
 */

namespace SuchTable\View\Helper;


use SuchTable\BaseInterface;
use SuchTable\ElementInterface;

class TableCell extends AbstractHelper
{
    protected $validTagAttributes = array('colspan' => true);

    public function __invoke(ElementInterface $element)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * @todo recursive render of childs elements
     *
     * @param BaseInterface $element
     * @return string
     */
    public function render(BaseInterface $element)
    {
        $helper = $this->getView()->plugin($element->getViewHelper());
        return $this->openTag($element->getAttributes()) . $helper->__invoke($element) . $this->closeTag();
    }

    /**
     * @param array $attributes
     * @return string
     */
    public function openTag(array $attributes = array())
    {
        return sprintf('<td %s>', $this->createAttributesString($attributes));
    }

    /**
     * @return string
     */
    public function closeTag()
    {
        return '</td>';
    }
}
