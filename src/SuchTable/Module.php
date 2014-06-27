<?php
namespace SuchTable;

use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * SuchTable Module definition.
 */
class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getServiceConfig()
    {
        if (class_exists('DoctrineORMModule\Service\DBALConnectionFactory')) {
            // For the doctrine examples!
            return array(
                'factories' => array(
                    'doctrine.connection.orm_suchTable' =>
                        new \DoctrineORMModule\Service\DBALConnectionFactory('orm_suchTable'),
                    'doctrine.configuration.orm_suchTable' =>
                        new \DoctrineORMModule\Service\ConfigurationFactory('orm_suchTable'),
                    'doctrine.entitymanager.orm_suchTable' =>
                        new \DoctrineORMModule\Service\EntityManagerFactory('orm_suchTable'),

                    'doctrine.driver.orm_suchTable' => new \DoctrineModule\Service\DriverFactory('orm_suchTable'),
                    'doctrine.eventmanager.orm_suchTable' =>
                        new \DoctrineModule\Service\EventManagerFactory('orm_suchTable'),
                    'doctrine.entity_resolver.orm_suchTable' =>
                        new \DoctrineORMModule\Service\EntityResolverFactory('orm_suchTable'),
                    'doctrine.sql_logger_collector.orm_suchTable' =>
                        new \DoctrineORMModule\Service\SQLLoggerCollectorFactory('orm_suchTable')
                )
            );
        }

        return array();
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }
}
