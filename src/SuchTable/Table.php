<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 16:17
 */

namespace SuchTable;


use Zend\Form\FormInterface;
use Zend\Stdlib\PriorityQueue;

class Table extends Element implements TableInterface
{
    protected $attributes = array(
        'class' => 'table table-bordered'
    );

    /**
     * @var array|\Traversable
     */
    protected $elements = array();

    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var PriorityQueue
     */
    protected $iterator;

    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var array|\Traversable
     */
    protected $data;

    /**
     * @param  null|int|string  $name    Optional name for the element
     * @param  array            $options Optional options for the element
     */
    public function __construct($name = null, $options = array())
    {
        $this->iterator = new PriorityQueue();
        parent::__construct($name, $options);
    }

    /**
     * @param Factory $factory
     * @return TableInterface
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
     * @return PriorityQueue
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
     * @return $this|TableInterface
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
        $order = 0;
        if (array_key_exists('priority', $flags)) {
            $order = $flags['priority'];
        }

        $this->iterator->insert($element, $order);
        $this->elements[$name] = $element;

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
     * @return $this
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

    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @todo check $data
     *
     * @param array|\ArrayAccess|\Traversable $data
     * @return Element|ElementInterface
     * @throws Exception\InvalidArgumentException
     */
    public function setData($data)
    {
        if (!is_array($data) && !$data instanceof \Traversable) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects an array or Traversable set of data; received "%s"',
                __METHOD__,
                (is_object($data) ? get_class($data) : gettype($data))
            ));
        }

        $this->data = $data;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
