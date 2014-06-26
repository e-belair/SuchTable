<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 03/03/14
 * Time: 09:55
 */

namespace SuchTable;


use Zend\Stdlib\ArrayUtils;

class Factory
{
    protected $tableElementManager;

    public function __construct(TableElementManager $tableElementManager = null)
    {
        if ($tableElementManager) {
            $this->setTableElementManager($tableElementManager);
        }
    }

    /**
     * @param mixed $tableElementManager
     *
     * @return Factory
     */
    public function setTableElementManager(TableElementManager $tableElementManager)
    {
        $this->tableElementManager = $tableElementManager;
        return $this;
    }

    /**
     * @return TableElementManager
     */
    public function getTableElementManager()
    {
        if (null === $this->tableElementManager) {
            $this->setTableElementManager(new TableElementManager());
        }

        return $this->tableElementManager;
    }

    /**
     * @param array|\Traversable $spec
     * @return ElementInterface
     * @throws Exception\DomainException
     */
    public function create($spec)
    {
        $type = isset($spec['type']) ? $spec['type'] : 'SuchTable\Element';
        $element = $this->getTableElementManager()->get($type);

        if ($element instanceof ElementInterface) {
            return $this->configureElement($element, $spec);
        }

        throw new Exception\DomainException(sprintf(
            '%s expects the $spec["type"] to implement one of %s, %s, or %s; received %s',
            __METHOD__,
            'SuchTable\Element\ElementInterface',
            'SuchTable\TableInterface',
            $type
        ));
    }

    public function configureElement(ElementInterface $element, $spec)
    {
        $spec = $this->validateSpecification($spec, __METHOD__);

        $name       = isset($spec['name'])       ? $spec['name']       : null;
        $options    = isset($spec['options'])    ? $spec['options']    : null;
        $attributes = isset($spec['attributes']) ? $spec['attributes'] : null;

        if ($name !== null && $name !== '') {
            $element->setName($name);
        }

        if (is_array($options) || $options instanceof \Traversable || $options instanceof \ArrayAccess) {
            $element->setOptions($options);
        }

        if (is_array($attributes) || $attributes instanceof \Traversable || $attributes instanceof \ArrayAccess) {
            $element->setAttributes($attributes);
        }

        return $element;
    }

    /**
     * @param array|\Traversable|\ArrayAccess $spec
     * @param string $method
     * @return array|\ArrayAccess
     * @throws Exception\InvalidArgumentException
     */
    protected function validateSpecification($spec, $method)
    {
        if (is_array($spec)) {
            return $spec;
        }

        if ($spec instanceof \Traversable) {
            $spec = ArrayUtils::iteratorToArray($spec);
            return $spec;
        }

        if (!$spec instanceof \ArrayAccess) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects an array, or object implementing Traversable or ArrayAccess; received "%s"',
                $method,
                (is_object($spec) ? get_class($spec) : gettype($spec))
            ));
        }

        return $spec;
    }
}
