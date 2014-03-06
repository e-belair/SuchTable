<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 03/03/14
 * Time: 10:23
 */

namespace SuchTable;


use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;
use Zend\Stdlib\InitializableInterface;

class TableElementManager extends AbstractPluginManager
{
    protected $invokableClasses = array(
        'element' => 'SuchTable\Element',
        'text' => 'SuchTable\Element\Text'
    );

    /**
     * Don't share form elements by default
     *
     * @var bool
     */
    protected $shareByDefault = false;

    public function __construct(ConfigInterface $configuration = null)
    {
        parent::__construct($configuration);

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
            'Plugin of type %s is invalid; must implement SuchTable\Table\ElementInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin))
        ));
    }

    /**
     * Retrieve a service from the manager by name
     *
     * Allows passing an array of options to use when creating the instance.
     * createFromInvokable() will use these and pass them to the instance
     * constructor if not null and a non-empty array.
     *
     * @param  string $name
     * @param  string|array $options
     * @param  bool $usePeeringServiceManagers
     * @return object
     */
    public function get($name, $options = array(), $usePeeringServiceManagers = true)
    {
        if (is_string($options)) {
            $options = array('name' => $options);
        }
        return parent::get($name, $options, $usePeeringServiceManagers);
    }

    /**
     * Attempt to create an instance via an invokable class
     *
     * Overrides parent implementation by passing $creationOptions to the
     * constructor, if non-null.
     *
     * @param  string $canonicalName
     * @param  string $requestedName
     * @return null|\stdClass
     * @throws Exception\ServiceNotCreatedException If resolved class does not exist
     */
    protected function createFromInvokable($canonicalName, $requestedName)
    {
        $invokable = $this->invokableClasses[$canonicalName];

        if (null === $this->creationOptions
            || (is_array($this->creationOptions) && empty($this->creationOptions))
        ) {
            $instance = new $invokable();
        } else {
            if (isset($this->creationOptions['name'])) {
                $name = $this->creationOptions['name'];
            } else {
                $name = $requestedName;
            }

            if (isset($this->creationOptions['options'])) {
                $options = $this->creationOptions['options'];
            } else {
                $options = $this->creationOptions;
            }

            $instance = new $invokable($name, $options);
        }

        return $instance;
    }
}
