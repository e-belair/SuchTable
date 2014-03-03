<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 03/03/14
 * Time: 10:23
 */

namespace ZendTable;


use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;
use Zend\Stdlib\InitializableInterface;

class TableElementManager extends AbstractPluginManager
{
    protected $invokableClasses = array(
        'text' => 'ZendTable\Element\Text'
    );

    public function __construct(ConfigInterface $configInterface = null)
    {
        parent::__construct($configInterface);

        $this->addInitializer(array($this, 'injectFactory'));
    }

    /**
     * Inject the factory to any element that implement TableFactoryAwareInterface
     *
     * @param $element
     */
    public function injectFactory($element)
    {
        if ($element instanceof TableFactoryAwareInterface) {
            $factory = $element->getTableFactory();
            $factory->setTableElementManager($this);
        }
    }

    /**
     * @param mixed $plugin
     * @throws Exception\InvalidElementException
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof InitializableInterface) {
            $plugin->init();
        }

        if ($plugin instanceof ElementInterface) {
            return;
        }

        throw new Exception\InvalidElementException(sprintf(
            'Plugin of type %s is invalid; must implement ZendTable\Table\ElementInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin))
        ));
    }
}
