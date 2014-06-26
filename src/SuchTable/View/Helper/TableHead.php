<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 18:35
 */

namespace SuchTable\View\Helper;


use SuchTable\Element;
use SuchTable\Fieldset\ElementFieldset;
use SuchTable\TableInterface;
use Zend\Form\View\Helper\FormText;

class TableHead extends AbstractHelper
{
    protected $tag = 'thead';

    /**
     * @param TableInterface $table
     * @return TableHead|string
     */
    public function __invoke(TableInterface $table = null)
    {
        if (!$table) {
            return $this;
        }

        return $this->render($table);
    }

    /**
     * @param TableInterface $table
     * @return string
     */
    public function render(TableInterface $table)
    {
        /** @var TableRow $tr */
        $tr = $this->getView()->plugin('tr');
        /** @var TableHeaderCell $th */
        $th = $this->getView()->plugin('th');
        /** @var TableCell $td */
        $td = $this->getView()->plugin('td');

        // @todo use other form element helpers
        /** @var FormText $formText */
        $formText = $this->getView()->plugin('formText');

        $content = '';
        foreach ($table as $element) {
            $content .= $th->render($element);
        }
        if ($content) {
            $content = $tr->openTag() . $content . $tr->closeTag();

            // Form?
            if ($table->getOption('headForm') !== false) {
                $formContent = '';
                /** @var ElementFieldset $fieldset */
                $fieldset = $table->getForm()->get($table->getElementsKey());
                $fieldset->prepareElement($table->getForm());
                /** @var Element $element */
                foreach ($table as $element) {
                    $name = $element->getName();
                    $formContent .= $td->openTag();
                    if ($element->getOption('disableForm') !== true && $fieldset->has($name)) {
                        $formContent .= $formText->__invoke($fieldset->get($name));
                    }
                    $formContent .= $td->closeTag();
                }
                if ($formContent) {
                    $content .= $tr->openTag() . $formContent . $tr->closeTag();
                }
            }

            return $this->openTag() . $content . $this->closeTag();
        }
    }

    /**
     * @todo attributes ?
     * @return string
     */
    public function openTag()
    {
        return '<thead>';
    }

    /**
     * @return string
     */
    public function closeTag()
    {
        return '</thead>';
    }
}
