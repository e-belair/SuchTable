<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 07/03/14
 * Time: 16:29
 */

namespace SuchTable;


use SuchTable\Exception\InvalidElementException;
use Zend\Paginator\Paginator;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\PriorityQueue;

class BaseElement implements BaseInterface
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
     * @var array|\Traversable|ElementInterface[]
     */
    protected $elements = array();

    /**
     * @var PriorityQueue
     */
    protected $iterator;

    /**
     * @var Factory
     */
    protected $factory;

    /**
     * untouched data
     *
     * rawData
     *
     * @var array|\Traversable
     */
    protected $data;

    /**
     * array of rows containing prepared elements
     *
     * @var array
     */
    protected $rows = array();

    /**
     * @var array
     */
    protected $reservedNames = array('order', 'way', 'page', 'itemsPerPage');

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

        $this->iterator = new PriorityQueue();
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
     * @param $option
     * @return bool
     */
    public function hasOption($option)
    {
        return isset($this->options[$option]);
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

    /**
     * @param Factory $factory
     * @return BaseInterface
     */
    public function setTableFactory(Factory $factory)
    {
        $this->factory = $factory;
        return $this;
    }

    /**
     * @return Factory
     */
    public function getTableFactory()
    {
        if (null === $this->factory) {
            $this->setTableFactory(new Factory());
        }

        return $this->factory;
    }

    /**
     * IteratorAggregate: return internal iterator
     *
     * @return PriorityQueue|ElementInterface[]
     */
    public function getIterator()
    {
        return $this->iterator;
    }

    /**
     * Countable: return count of attached elements
     *
     * @return int
     */
    public function count()
    {
        return $this->iterator->count();
    }

    /**
     * @param array|\Traversable|ElementInterface $element
     * @param array $flags
     * @return BaseElement
     * @throws Exception\InvalidArgumentException
     */
    public function add($element, array $flags = array())
    {
        if (is_array($element)
            || ($element instanceof \Traversable && !$element instanceof ElementInterface)) {


            $factory = $this->getTableFactory();
            $element = $factory->create($element);
        }

        if (!$element instanceof ElementInterface) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s requires that $element be an object implementing %s; received "%s"',
                __METHOD__,
                __NAMESPACE__ . '\ElementInterface',
                (is_object($element) ? get_class($element) : gettype($element))
            ));
        }

        $name = $element->getName();
        if ((null === $name || '' === $name)
            && (!array_key_exists('name', $flags) || $flags['name'] === '')
        ) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s: element provided is not named, and no name provided in flags',
                __METHOD__
            ));
        }

        if (array_key_exists('name', $flags) && $flags['name'] !== '') {
            $name = $flags['name'];

            // Rename the element to the specified alias
            $element->setName($name);
        }

        if (in_array($name, $this->reservedNames)) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s: element provided has a reserved name',
                __METHOD__
            ));
        }

        $order = 0;
        if (array_key_exists('priority', $flags)) {
            $order = $flags['priority'];
        }

        if ($this instanceof Table) {
            $element->setTable($this);
        }

        $this->iterator->insert($element, $order);
        $this->elements[$name] = $element;

        if ($this instanceof TableInterface) {
            if (true !== $this->getOption('disableForm')
                && true !== $element->getOption('disableForm')) {
                $this->getForm()->get($this->getElementsKey())->addTableElement($element);
                $this->getForm()->getInputFilter()->get($this->getElementsKey())->addTableElement($element);
            }

            $this->getForm()->getInputFilter()->get($this->getParamsKey())->addTableElement($element);
        }

        return $this;
    }

    /**
     * @param string $element
     * @return ElementInterface
     * @throws Exception\InvalidElementException
     */
    public function get($element)
    {
        if (!$this->has($element)) {
            throw new Exception\InvalidElementException(sprintf(
                "No element by the name of [%s] found in table",
                $element
            ));
        }

        return $this->elements[$element];
    }

    /**
     * @param string $element
     * @return bool
     */
    public function has($element)
    {
        return array_key_exists($element, $this->elements);
    }

    /**
     * @param $element
     * @return BaseInterface
     */
    public function remove($element)
    {
        if (!$this->has($element)) {
            return $this;
        }
        $this->iterator->remove($this->elements[$element]);
        unset($this->elements[$element]);

        return $this;
    }

    public function setPriority($element, $priority)
    {
        // TODO: Implement setPriority() method.
    }

    /**
     * @return array|\Traversable|ElementInterface[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @param array|\ArrayAccess|\Traversable $data
     * @return TableInterface
     * @throws Exception\InvalidArgumentException
     */
    public function setData($data)
    {
        $this->data = $data;
        $this->isPrepared = false;
        return $this;
    }

    /**
     * @return array|\Traversable
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return BaseElement
     * @throws Exception\InvalidElementException
     */
    public function prepare()
    {
        if ($this->isPrepared === true) {
            return $this;
        }

        $this->rows = [];
        $datas = $this->getData();

        if (is_array($datas) || $datas instanceof \ArrayAccess || $datas instanceof Paginator) {
            foreach ($datas as $key => $data) {
                $row = [];
                /** @var ElementInterface $element */
                foreach ($this as $element) {
                    $row[$element->getName()] = $this->cloneElement($element, $data);
                }

                // @todo verify above or improve it ;-)
                // If collection
                if (is_int($key)) {
                    $this->rows[] = $row;
                } else {
                    // If one to one
                    $this->rows = $row;
                }
            }
        } elseif (is_object($datas)) {
            // Should have one element only
            $row = [];
            /** @var ElementInterface $element */
            foreach ($this as $element) {
                $row[$element->getName()] = $this->cloneElement($element, $datas);
            }
            $this->rows[] = $row;
        }

        $this->isPrepared = true;
        return $this;
    }

    protected function cloneElement(ElementInterface $element, $data)
    {
        $element = clone($element);
        $element->setParent($this);
        if ($this instanceof Table) {
            $element->setTable($this)->setRowData($data);
        } else {
            $element->setTable($this->getTable())->setRowData($this->getRowData());
        }

        if (is_object($data)) {
            $getter = 'get'.ucfirst(strtolower($element->getName()));
            if (method_exists($data, $getter)) {
                $element->setData($data->$getter());
            } elseif (property_exists($data, $element->getName())) {
                $element->setData($data->{$element->getName()});
            }
        } elseif (is_array($data) && !empty($data[$element->getName()])) {
            $element->setData($data[$element->getName()]);
        } elseif (is_string($data)) {
            $element->setData($data);
        }

        // Check if element mapped to the content
        if ((is_object($element->getData()) || is_array($element->getData())) && $element->count() == 0) {
            if ($element->getIterator()->count() == 0) {
                throw new InvalidElementException(
                    sprintf('Missing element for array|object data of element %s', $element->getName())
                );
            }
        }

        foreach ($element->getAttributes() as $name => $attribute) {
            if (is_callable($attribute)) {
                $element->setAttribute($name, (string) call_user_func($attribute, $element));
            }
        }

        foreach ($element->getOptions() as $option => $value) {
            if (is_callable($value)) {
                $element->setOption($option, (string) call_user_func($value, $element));
            }
        }

        return $element;
    }

    /**
     * @return array
     */
    public function getRows()
    {
        if (false === $this->isPrepared) {
            $this->prepare();
        }

        return $this->rows;
    }
}
