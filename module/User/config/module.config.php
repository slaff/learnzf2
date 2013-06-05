<?php
return array(
    'controllers' => array(
        'invokables' => array(
           // below is key              and below is the fully qualified class name
           'User\Controller\Account' => 'User\Controller\AccountController',
           'User\Controller\Log'     => 'User\Controller\LogController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'user' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/user',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'Account',
                        'action'        => 'me',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[0-9]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'User' => __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array (
        'factories' => array(
            'database' 	       => 'User\Service\Factory\Database',
            'entity-manager'   => 'User\Service\Factory\EntityManager',
            'log'	       => 'User\Service\Factory\Log',
            'password-adapter' => 'User\Service\Factory\PasswordAdapter',
        ),
        'invokables' => array(
            'table-gateway'     => 'User\Service\Invokable\TableGateway',
            'user-entity'       => 'User\Model\Entity\User',
            'doctrine-profiler' => 'User\Service\Invokable\DoctrineProfiler',
        ),
        'shared' => array(
            'user-entity' => false,
        ),
        'initializers' => array (
            'User\Service\Initializer\Password'
        ),
    ),
    'table-gateway' => array(
        'map' => array(
            'users' => 'User\Model\User',
        )
    ),
    'doctrine' => array(
        'entity_path' => array (
                __DIR__ . '/../src/User/Model/Entity/',
        ),
        'initializers' => array (
            // add here the list of initializers for Doctrine 2 entities..
            'User\Service\Initializer\Password'
        ),
    ),
);
