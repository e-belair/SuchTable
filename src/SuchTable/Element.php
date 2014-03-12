<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 16:32
 */

namespace SuchTable;


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
     * @var TableInterface
     */
    protected $table;

    /**
     * @var BaseElement
     */
    protected $parent;

    /**
     * @param string $key
     * @param string $value
     * @return ElementInterface
     */
    public function setAttribute($key, $value)
    {
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
     * @return BaseElement
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param BaseElement $parent
     *
     * @return Element
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }
}
