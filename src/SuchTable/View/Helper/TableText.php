<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 05/03/14
 * Time: 21:12
 */

namespace SuchTable\View\Helper;

use SuchTable\BaseElement;

class TableText extends AbstractHelper
{
    public function __invoke(BaseElement $element = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    public function render(BaseElement $element)
    {
        return $this->getContent($element);
    }
}
