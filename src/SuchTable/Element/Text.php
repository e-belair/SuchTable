<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 16:33
 */

namespace SuchTable\Element;


use SuchTable\Element;

class Text extends Element
{
    public function getValue()
    {
        return $this->getData();
    }
}
