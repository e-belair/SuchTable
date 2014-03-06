<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 05/03/14
 * Time: 21:12
 */

namespace SuchTable\View\Helper;


use SuchTable\Element\Text;

class TableText extends AbstractHelper
{
    public function __invoke(Text $element)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    public function render(Text $element)
    {
        return $element->getValue();
    }
}
