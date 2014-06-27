<?php

return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'table' => 'SuchTable\View\Helper\Table',
            'thead' => 'SuchTable\View\Helper\TableHead',
            'tbody' => 'SuchTable\View\Helper\TableBody',
            'tfoot' => 'SuchTable\View\Helper\TableFoot',
            'tr'    => 'SuchTable\View\Helper\TableRow',
            'th'    => 'SuchTable\View\Helper\TableHeaderCell',
            'td'    => 'SuchTable\View\Helper\TableCell',

            // Content helpers
            'tableText'    => 'SuchTable\View\Helper\TableText',
            'tableLink'    => 'SuchTable\View\Helper\TableLink',
            'tableDescriptionList' => 'SuchTable\View\Helper\TableDescriptionList',
            'tableDescriptionTerm' => 'SuchTable\View\Helper\TableDescriptionTerm',
            'tableDescriptionDesc' => 'SuchTable\View\Helper\TableDescriptionDesc',
            'tableUnorderedList'   => 'SuchTable\View\Helper\TableUnorderedList',
            'tableOrderedList'     => 'SuchTable\View\Helper\TableOrderedList',
            'tableListItem'        => 'SuchTable\View\Helper\TableListItem',
        )
    ),

    /**
     * EXAMPLE AND TESTS
     */
    'controllers' => array(
        'invokables' => array(
            'SuchTable\Example\Controller\Employee' => 'SuchTable\Example\Controller\EmployeeController'
        )
    ),
    'router' => array(
        'routes' => array(
            'SuchTable' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/suchTable',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SuchTable\Example\Controller',
                        'controller' => 'employee',
                        'action' => 'index'
                    )
                ),
            )
        )
    ),
    'suchTable_dbAdapter' => array(
        'driver' => 'Pdo_Sqlite',
        'database' => __DIR__ . '/../data/employees.sqlite'
    ),

    'doctrine' => array(
        'connection' => array(
            'orm_suchTable' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
                'params' => array(
                    'charset' => 'utf8',
                    'path' => __DIR__ . '/../data/employees.sqlite'
                )
            )
        ),

        'configuration' => array(
            'orm_suchTable' => array(
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'result_cache' => 'array',
                'driver' => 'orm_suchTable',
                'generate_proxies' => true,
                'proxy_dir' => 'data/SuchTable/Proxy',
                'proxy_namespace' => 'SuchTable\Proxy',
                'filters' => array()
            )
        ),

        'driver' => array(
            'SuchTable_Driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/SuchTable/Example/Entity'
                )
            ),

            'orm_suchTable' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\DriverChain',
                'drivers' => array(
                    'SuchTable\Example\Entity' => 'SuchTable_Driver'
                )
            )
        ),

        'entitymanager' => array(
            'orm_suchTable' => array(
                'connection' => 'orm_suchTable',
                'configuration' => 'orm_suchTable'
            )
        ),

        'eventmanager' => array(
            'orm_crawler' => array()
        ),

        'sql_logger_collector' => array(
            'orm_crawler' => array()
        ),

        'entity_resolver' => array(
            'orm_crawler' => array()
        )
    )
);
