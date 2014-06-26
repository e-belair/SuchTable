<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 19:02
 */

namespace SuchTable\View\Helper;

use SuchTable\BaseInterface;
use SuchTable\ElementInterface;
use Zend\I18n\View\Helper\AbstractTranslatorHelper as BaseAbstractHelper;
use Zend\View\Helper\EscapeHtml;
use Zend\View\Helper\EscapeHtmlAttr;
use ZendTest\XmlRpc\Server\Exception;

abstract class AbstractHelper extends BaseAbstractHelper
{
    /**
     * @var EscapeHtml
     */
    protected $escapeHtmlHelper;

    /**
     * @var EscapeHtmlAttr
     */
    protected $escapeHtmlAttrHelper;

    /**
     * @todo attributes missing?
     *
     * @var array
     */
    protected $validGlobalAttributes = array(
        'accesskey'          => true,
        'class'              => true,
        'contenteditable'    => true,
        'contextmenu'        => true,
        'dir'                => true,
        'draggable'          => true,
        'dropzone'           => true,
        'hidden'             => true,
        'id'                 => true,
        'lang'               => true,
        'onclick'            => true,
        'ondblclick'         => true,
        'onmousedown'        => true,
        'onmousemove'        => true,
        'onmouseout'         => true,
        'onmouseover'        => true,
        'onmouseup'          => true,
        'onmousewheel'       => true,
        'spellcheck'         => true,
        'style'              => true,
        'tabindex'           => true,
        'title'              => true,
        'translate'          => true,
    );

    /**
     * Attributes valid for the tag represented by this helper
     *
     * This should be overridden in extending classes
     *
     * @var array
     */
    protected $validTagAttributes = array(
    );

    /**
     * Recursive render child elements or content of element
     *
     * @param ElementInterface $element
     * @return int|string
     */
    public function getContent(ElementInterface $element)
    {
        if (count($element->getRows()) > 0) {
            $content = '';
            foreach ($element->getRows() as $row) {
                if ($row instanceof ElementInterface) {
                    $content .= $this->renderByHelper($row);
                } else {
                    /** @var ElementInterface $el */
                    foreach ($row as $el) {
                        $content .= $this->renderByHelper($el);
                    }
                }
            }
            return $content;
        }

        $data = $element->getData();
        return (is_string($data) || is_int($data)) ? $data : '';
    }

    protected function renderByHelper(ElementInterface $element)
    {
        $type = $element->getType();
        $helperType = 'table' . ucfirst($type);
        $helper = $this->getView()->plugin($helperType);
        return $helper->render($element);
    }

    /**
     * @param array $attributes
     * @return string
     */
    public function createAttributesString(array $attributes)
    {
        $attributes = $this->prepareAttributes($attributes);
        $escape     = $this->getEscapeHtmlHelper();
        $strings    = array();
        foreach ($attributes as $key => $value) {
            $key = strtolower($key);

            $strings[] = sprintf('%s="%s"', $escape($key), $escape($value));
        }
        return implode(' ', $strings);
    }

    /**
     * @param array $attributes
     * @return array
     */
    protected function prepareAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $attribute = strtolower($key);

            if (!isset($this->validGlobalAttributes[$attribute])
                && !isset($this->validTagAttributes[$attribute])
                && 'data-' != substr($attribute, 0, 5)
                && 'x-' != substr($attribute, 0, 2)
            ) {
                // Invalid attribute for the current tag
                unset($attributes[$key]);
                continue;
            }

            // Normalize attribute key, if needed
            if ($attribute != $key) {
                unset($attributes[$key]);
                $attributes[$attribute] = $value;
            }
        }

        return $attributes;
    }

    /**
     * Retrieve the escapeHtml helper
     *
     * @return EscapeHtml
     */
    protected function getEscapeHtmlHelper()
    {
        if ($this->escapeHtmlHelper) {
            return $this->escapeHtmlHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->escapeHtmlHelper = $this->view->plugin('escapehtml');
        }

        if (!$this->escapeHtmlHelper instanceof EscapeHtml) {
            $this->escapeHtmlHelper = new EscapeHtml();
        }

        return $this->escapeHtmlHelper;
    }

    /**
     * Retrieve the escapeHtmlAttr helper
     *
     * @return EscapeHtmlAttr
     */
    protected function getEscapeHtmlAttrHelper()
    {
        if ($this->escapeHtmlAttrHelper) {
            return $this->escapeHtmlAttrHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->escapeHtmlAttrHelper = $this->view->plugin('escapehtmlattr');
        }

        if (!$this->escapeHtmlAttrHelper instanceof EscapeHtmlAttr) {
            $this->escapeHtmlAttrHelper = new EscapeHtmlAttr();
        }

        return $this->escapeHtmlAttrHelper;
    }
}
