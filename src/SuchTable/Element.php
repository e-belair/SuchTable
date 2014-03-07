<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 16:32
 */

namespace SuchTable;


use SuchTable\Exception\InvalidElementException;

abstract class Element extends BaseElement implements ElementInterface
{
    /**
     * @var string
     */
    protected $type = 'text';

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

    public function setOptions($options)
    {
        parent::setOptions($options);

        if (isset($options['label'])) {
            $this->setLabel($options['label']);
        }

        if (isset($options['label_attributes'])) {
            $this->setLabelAttributes($options['label_attributes']);
        }

        return $this;
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
