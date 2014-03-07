<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 07/03/14
 * Time: 16:27
 */

namespace SuchTable;


interface BaseInterface
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
}
