<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 05/03/14
 * Time: 20:56
 */

namespace SuchTable\View\Helper;


use SuchTable\Element\Link;
use SuchTable\Exception\InvalidElementException;

class TableLink extends AbstractHelper
{
    protected $validTagAttributes = array(
        'href'   => true,
        'title'  => true,
        'target' => true,
    );

    public function __invoke(Link $element = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    public function render(Link $element)
    {
        $value = $element->getValue();
        $attributes = $element->getAttributes();
        if (isset($attributes['href'])) {
            $href = $attributes['href'];
            unset($attributes['href']);
        } elseif ($value) {
            $href = $value;
        } else {
            return null;
        }

        $innerHtml = $element->getOption('innerHtml');
        if (!$innerHtml) {
            throw new InvalidElementException('innerHtml option has to be set for link element');
        }

        return sprintf('<a href="%s" %s>%s</a>', $href, $this->createAttributesString($attributes), $innerHtml);
    }
}
