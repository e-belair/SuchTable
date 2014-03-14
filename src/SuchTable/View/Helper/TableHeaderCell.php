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
        $table = $element->getTable();
        $form  = $table->getForm();

        $label = $element->getLabel();

        if ($label && $element->getOption('disableOrderBy') !== true) {
            $onclick = str_replace(
                array('%FORM_NAME%', '%ORDER_ELEMENT%', '%WAY_ELEMENT%', '%ORDER%', '%WAY%'),
                array(
                    $table->getName() . '-form',
                    $table->getName() . '-params[order]',
                    $table->getName() . '-params[way]',
                    $element->getName(),
                    $form->get($table->getName() . '-params')->get('way')->getValue() == 'ASC' ? 'DESC' : 'ASC'
                ),
                "document.forms['%FORM_NAME%'].elements['%ORDER_ELEMENT%'].value = '%ORDER%';" .
                "document.forms['%FORM_NAME%'].elements['%WAY_ELEMENT%'].value = '%WAY%';" .
                "document.forms['%FORM_NAME%'].submit(); return false;"
            );
            $label = '<a href="javascript:void(0);" onclick="'.$onclick.'">' . $label . '</a>';
        }

        return $this->openTag($element) . $label . $this->closeTag();
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
