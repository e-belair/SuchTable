<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 26/06/14
 * Time: 15:24
 */

namespace SuchTable\InputFilter;


use SuchTable\ElementInterface;
use Zend\InputFilter\InputFilter;

class ParamsInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'page',
            'required' => false,
            'filters' => [new \Zend\Filter\ToInt()]
        ])->add([
            'name' => 'way',
            'required' => true,
            'validators' => [new \Zend\Validator\InArray(['haystack' => ['ASC', 'DESC']])]
        ])->add([
            'name' => 'order',
            'required' => false,
            'validators' => [new \Zend\Validator\InArray(['haystack' => []])]
        ])->add([
            'name' => 'itemsPerPage',
            'required' => true,
            'filters' => [new \Zend\Filter\ToInt()]
        ]);
    }

    /**
     * Make sure that 'order by' is part of elements
     *
     * @param ElementInterface $element
     */
    public function addTableElement(ElementInterface $element)
    {
        /** @var \Zend\Validator\InArray $inArrayValidator */
        $inArrayValidator = $this->get('order')->getValidatorChain()->getValidators()[0]['instance'];
        $haystack = $inArrayValidator->getHaystack();
        $haystack[] = $element->getName();
        $inArrayValidator->setHaystack($haystack);
    }
}
