<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 07/03/14
 * Time: 16:29
 */

namespace SuchTable;


use Zend\Stdlib\ArrayUtils;

class BaseElement
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * Content Element attributes
     *
     * @var array
     */
    protected $attributes = array();

    /**
     * @var bool
     */
    protected $isPrepared = false;

    /**
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, $options = array())
    {
        if (null !== $name) {
            $this->setName($name);
        }

        if (!empty($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * @param string $name
     *
     * @return Element
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $options
     * @return $this|ElementInterface
     * @throws Exception\InvalidArgumentException
     */
    public function setOptions($options)
    {
        if ($options instanceof \Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (!is_array($options)) {
            throw new Exception\InvalidArgumentException(
                'The options parameter must be an array or a Traversable'
            );
        }

        $this->options = $options;
        $this->isPrepared = false;

        return $this;
    }

    /**
     * @param $option
     * @param $value
     * @return ElementInterface
     */
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
        $this->isPrepared = false;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
    /**
     * @param $option
     * @return mixed|null
     */
    public function getOption($option)
    {
        if (!isset($this->options[$option])) {
            return null;
        }

        return $this->options[$option];
    }

    /**
     * @param string $key
     * @param string $value
     * @return BaseInterface
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param $key
     * @return null|string
     */
    public function getAttribute($key)
    {
        if (!array_key_exists($key, $this->attributes)) {
            return null;
        }
        return $this->attributes[$key];
    }

    /**
     * @param $key
     * @return BaseInterface
     */
    public function removeAttribute($key)
    {
        unset($this->attributes[$key]);
        return $this;
    }

    /**
     * @param array $keys
     * @return BaseInterface
     */
    public function removeAttributes(array $keys)
    {
        foreach ($keys as $key) {
            unset($this->attributes[$key]);
        }

        return $this;
    }

    /**
     * @return BaseInterface
     */
    public function clearAttributes()
    {
        $this->attributes = array();
        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasAttribute($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     * @param array|\Traversable $arrayOrTraversable
     * @return $this
     * @throws Exception\InvalidArgumentException
     */
    public function setAttributes($arrayOrTraversable)
    {
        if (!is_array($arrayOrTraversable) && !$arrayOrTraversable instanceof \Traversable) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects an array or Traversable argument; received "%s"',
                __METHOD__,
                (is_object($arrayOrTraversable) ? get_class($arrayOrTraversable) : gettype($arrayOrTraversable))
            ));
        }
        foreach ($arrayOrTraversable as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

}
