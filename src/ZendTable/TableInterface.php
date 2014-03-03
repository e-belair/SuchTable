<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 19:45
 */

namespace ZendTable;


interface TableInterface extends
    ElementInterface,
    \Countable,
    \IteratorAggregate
{
    /**
     * @param \Traversable|ElementInterface $element
     * @param array                         $flags
     * @return TableInterface
     */
    public function add($element, array $flags = array());

    /**
     * @param string $element
     * @return bool
     */
    public function has($element);

    /**
     * @param string $element
     * @return ElementInterface
     */
    public function get($element);

    /**
     * @param string $element
     * @return TableInterface
     */
    public function remove($element);

    /**
     * @param $element
     * @param $priority
     * @return mixed
     */
    public function setPriority($element, $priority);

    /**
     * @return array
     */
    public function getElements();
}
