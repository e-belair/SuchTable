<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 05/03/14
 * Time: 20:56
 */

namespace ZendTable\View\Helper;


use ZendTable\Element\Link;
use ZendTable\Exception\InvalidElementException;

class TableLink extends AbstractHelper
{
    protected $validTagAttributes = array(
        'href'  => true,
        'title' => true
    );

    public function __invoke(Link $element)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    public function render(Link $element)
    {
        $attributes = $element->getAttributes();
        if (!isset($attributes['href'])) {
            throw new InvalidElementException('href attribute has to be set for link element');
        }

        if (is_callable($attributes['href'])) {
            $attributes['href'] = (string) call_user_func($attributes['href'], $element);
        }
        $href = $attributes['href'];
        unset($attributes['href']);

        $innerHTML = $element->getInnerHtml();
        if (!$innerHTML) {
            throw new InvalidElementException('innerHtml option has to be set for link element');
        }
        if (is_callable($innerHTML)) {
            $innerHTML = (string) call_user_func($innerHTML, $element);
        }

        return sprintf('<a href="%s" %s>%s</a>', $href, $this->createAttributesString($attributes), $innerHTML);
    }
}
