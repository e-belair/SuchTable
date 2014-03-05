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
    protected $type = 'link';

    /**
     * @var string|callable
     */
    protected $innerHtml;

    public function setOptions($options)
    {
        parent::setOptions($options);

        if (isset($options['innerHtml'])) {
            $this->setInnerHtml($options['innerHtml']);
        }
    }

    /**
     * @param callable|string $innerHtml
     *
     * @return Link
     */
    public function setInnerHtml($innerHtml)
    {
        $this->innerHtml = $innerHtml;
        return $this;
    }

    /**
     * @return callable|string
     */
    public function getInnerHtml()
    {
        return $this->innerHtml;
    }
}
