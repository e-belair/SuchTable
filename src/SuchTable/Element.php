<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 16:32
 */

namespace SuchTable;


use SuchTable\Exception\InvalidElementException;
use Zend\Stdlib\ArrayUtils;

class Element implements ElementInterface
{
    /**
     * @var string
     */
    protected $type = 'text';

    /**
     * @var string
     */
    protected $name;

    /**
     * TH Content
     *
     * @var mixed
     */
    protected $label;

    /**
     * TH Attributes
     *
     * @var array
     */
    protected $labelAttributes = array();

    /**
     * Modified data
     *
     * @var mixed
     */
    protected $value;

    /**
     * Content Element attributes
     *
     * @var array
     */
    protected $attributes = array();

    /**
     * @var TableInterface
     */
    protected $table;

    /**
     * Unmodified RowData
     *
     * @var array|\Traversable
     */
    protected $rowData;

    /**
     * @var array
     */
    protected $options = array();

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
     * @param string $type
     *
     * @return Element
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * @return ElementInterface
     */
    public function setAttribute($key, $value)
    {
        // Do not include the value in the list of attributes
        if ($key === 'value') {
            $this->setValue($value);
            return $this;
        }
        $this->attributes[$key] = $value;
        return $this;
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
     * @return ElementInterface
     */
    public function removeAttribute($key)
    {
        unset($this->attributes[$key]);
        return $this;
    }

    /**
     * @param array $keys
     * @return ElementInterface
     */
    public function removeAttributes(array $keys)
    {
        foreach ($keys as $key) {
            unset($this->attributes[$key]);
        }

        return $this;
    }

    /**
     * @return ElementInterface
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
     * @return ElementInterface
     * @throws Exception\InvalidElementException
     */
    public function prepare()
    {
        if ($this->isPrepared === true) {
            return $this;
        }

        foreach ($this->getAttributes() as $name => $attribute) {
            if (is_callable($attribute)) {
                $this->setAttribute($name, (string) call_user_func($attribute, $this));
            }
        }

        foreach ($this->getOptions() as $option => $value) {
            if (is_callable($value)) {
                $this->setOption($option, (string) call_user_func($value, $this));
            }
        }

        $rowData = $this->getRowData();
        if (is_object($rowData)) {
            $getter = 'get'.ucfirst(strtolower($this->getName()));
            if (method_exists($rowData, $getter)) {
                try {
                    $this->setValue($rowData->$getter());
                } catch (\Exception $e) {
                    throw new InvalidElementException(
                        sprintf('object method "%s" has to be accessible', $getter)
                    );
                }
            } elseif (property_exists($rowData, $this->getName())) {
                try {
                    $this->setValue($rowData->{$this->getName()});
                } catch (\Exception $e) {
                    throw new InvalidElementException(
                        sprintf(
                            'object property "%s" has to be accessible or contain getter like "%s"',
                            $this->getName(),
                            $getter
                        )
                    );
                }
            }
        } elseif (is_array($rowData)) {
            if (isset($rowData[$this->getName()])) {
                $this->setValue($rowData[$this->getName()]);
            }
        } else {
            throw new InvalidElementException('type of data not recognized');
        }

        $this->isPrepared = true;
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
     * @param $rowData
     * @return ElementInterface
     */
    public function setRowData($rowData)
    {
        $this->rowData = $rowData;
        $this->isPrepared = false;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRowData()
    {
        return $this->rowData;
    }

    /**
     * @param TableInterface $table
     * @return ElementInterface
     */
    public function setTable(TableInterface $table)
    {
        $this->table = $table;
        $this->isPrepared = false;
        return $this;
    }

    /**
     * @return TableInterface
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $label
     *
     * @return Element
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param array $labelAttributes
     *
     * @return Element
     */
    public function setLabelAttributes(array $labelAttributes)
    {
        $this->labelAttributes = $labelAttributes;
        return $this;
    }

    /**
     * @return array
     */
    public function getLabelAttributes()
    {
        return $this->labelAttributes;
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

        if (isset($options['label'])) {
            $this->setLabel($options['label']);
        }

        if (isset($options['label_attributes'])) {
            $this->setLabelAttributes($options['label_attributes']);
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
     * @param mixed $value
     *
     * @return Element
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Return formatted value
     *
     * @return mixed
     */
    public function getValue()
    {
        $this->prepare();

        return $this->value;
    }
}
