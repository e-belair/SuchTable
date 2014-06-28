<?php

return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'SuchTable',
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            __DIR__ . '/../config/module.config.php',
        ),
        'module_paths' => array(
            __DIR__ . '/../vendor',
        ),
    ),
);
