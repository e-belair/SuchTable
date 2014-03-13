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
        /** @var TableListItem $li */
        $li = $this->getView()->plugin('tableListItem');
        $tag = $element->getType() == 'unorderedList' ? 'ul' : 'ol';
        $content = '';
        foreach ($element->getRows() as $row) {
            foreach ($row as $el) {
                $content .= $li->render($el);
            }
        }

        if ($content) {
            return sprintf(
                '<%s %s>%s</%s>',
                $tag,
                $this->createAttributesString($element->getAttributes()),
                $content,
                $tag
            );
        }
    }
}
