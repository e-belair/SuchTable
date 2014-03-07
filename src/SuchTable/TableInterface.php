<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 19:45
 */

namespace SuchTable;


interface TableInterface extends
    BaseInterface,
    \Countable,
    \IteratorAggregate
{
    /**
     * @param Factory $factory
     * @return TableInterface
     */
    public function setTableFactory(Factory $factory);

    /**
     * @return Factory
     */
    public function getTableFactory();

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

    /**
     * @param $data
     * @return mixed
     */
    public function setData($data);

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return array
     */
    public function getRows();

    /**
     * Prepare and populate the table with rows & elements
     *
     * @return BaseElement
     */
    public function prepare();
}
