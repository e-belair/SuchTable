<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 07/03/14
 * Time: 16:27
 */

namespace SuchTable;


interface BaseInterface extends \Countable, \IteratorAggregate
{
    /**
     * @param $name
     * @return TableInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param $options
     * @return TableInterface
     */
    public function setOptions($options);

    /**
     * @return array
     */
    public function getOptions();

    /**
     * @param $option
     * @return mixed
     */
    public function getOption($option);

    /**
     * @param $option
     * @param $value
     * @return mixed
     */
    public function setOption($option, $value);

    /**
     * @param array|\Traversable $arrayOrTraversable
     * @return TableInterface
     */
    public function setAttributes($arrayOrTraversable);

    /**
     * @param string $key
     * @param string $value
     * @return TableInterface
     */
    public function setAttribute($key, $value);

    /**
     * @param $key
     * @return string|null
     */
    public function getAttribute($key);

    /**
     * @param $key
     * @return TableInterface
     */
    public function removeAttribute($key);

    /**
     * @param array $keys
     * @return TableInterface
     */
    public function removeAttributes(array $keys);

    /**
     * @return TableInterface
     */
    public function clearAttributes();

    /**
     * @param $key
     * @return bool
     */
    public function hasAttribute($key);

    /**
     * @return array
     */
    public function getAttributes();

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
     * @return ElementInterface
     * @throws Exception\InvalidElementException
     */
    public function prepare();

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
}
