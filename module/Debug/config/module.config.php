<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            'Debug' => __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'timer' => 'Debug\Service\Factory\Timer'
        ),
        'initializers' => array(
            'Debug\Service\Initializer\DbProfiler',
            'Debug\Service\Initializer\CacheProfiler',
        ),
        'aliases' => array(
            'Application\Timer' => 'timer',
        )
    ),
    'timer' => array (
        'times_as_float' => true,
    )
);
