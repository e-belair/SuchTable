<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 03/03/14
 * Time: 22:14
 */

namespace ZendTable\Element;


use ZendTable\Element;

class Link extends Element
{
    // TODO set Options url
    public function getValue()
    {
        return $this->getData();
    }
}
