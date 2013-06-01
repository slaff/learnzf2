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
    	'template_map' => include __DIR__  . '/../template_map.php',
    ),
    'service_manager' => array (
        'factories' => array(
            'database' 	       => 'User\Service\Factory\Database',
            'entity-manager'   => 'User\Service\Factory\EntityManager',
            'log'	       => 'User\Service\Factory\Log',
            'password-adapter' => 'User\Service\Factory\PasswordAdapter',
            'auth' 	       => 'User\Service\Factory\Authentication',
            'acl'	       => 'User\Service\Factory\Acl',
            'user'	       => 'User\Service\Factory\User',
        ),
        'invokables' => array(
            'table-gateway'     => 'User\Service\Invokable\TableGateway',
            'user-entity'       => 'User\Model\Entity\User',
            'doctrine-profiler' => 'User\Service\Invokable\DoctrineProfiler',
            'auth-adapter' 	=> 'User\Authentication\Adapter',
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

    'acl' => array(
        'role' => array (
                // role -> multiple parents
                'guest'   => null,
                'member'  => array('guest'),
                'admin'   => null,
        ),
        'resource' => array (
                // resource -> single parent
                'account' => null,
                'log'     => null,
        ),
        'allow' => array (
                // array('role', 'resource', array('permission-1', 'permission-2', ...)),
                array('guest', 'log', 'in'),
                array('guest', 'account', 'register'),
                array('member', 'account', array('me')), // the member can only see his account
                array('member', 'log', 'out'), // the member can log out
                array('admin', null, null), // the admin can do anything with the accounts
        ),
        'deny'  => array (
                array('guest', null, 'delete') // null as second parameter means
                // all resources

        ),
        'defaults' => array (
                'guest_role' => 'guest',
                'member_role' => 'member',
        ),
        'resource_aliases' => array (
                'User\Controller\Account' => 'account',
        ),

        // List of modules to apply the ACL. This is how we can specify if we have to protect the pages in our current module.
        'modules' => array (
                'User',
        ),
    ),
    // Below is the menu navigation for this module
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'User',
                'route' => 'user/default',
                'controller'=> 'account',
                'pages' => array(
                        array(
                            'label' => 'Me',
                            'route' => 'user/default',
                            'controller' => 'account',
                            'action' => 'me',
                            'resource' => 'account',
                            'privilege' => 'me',
                        ),
                        array(
                            'label' => 'Add',
                            'route' => 'user/default',
                            'controller' => 'account',
                            'action' => 'add',
                            'resource' => 'account',
                            'privilege' => 'add',
                        ),
                        array(
                            'label' => 'View',
                            'route' => 'user/default',
                            'controller' => 'account',
                            'action' => 'view',
                            'resource' => 'account',
                            'privilege' => 'view',
                        ),
                        array(
                            'label' => 'Edit',
                            'route' => 'user/default',
                            'controller' => 'account',
                            'action' => 'edit',
                            'resource' => 'account',
                            'privilege' => 'edit',
                        ),
                        array(
                            'label' => 'Delete',
                            'route' => 'user/default',
                            'controller' => 'account',
                            'action' => 'delete',
                            'resource' => 'account',
                            'privilege' => 'delete',
                        ),
                        array(
                            'label' => 'Log in',
                            // uri
                            'route' => 'user/default',
                            'controller' => 'log',
                            'action'    => 'in',
                            // acl
                            'resource'  => 'log',
                            'privilege' => 'in'
                        ),

                        array(
                            'label' => 'Register',
                            // uri
                            'route' => 'user/default',
                            'controller' => 'account',
                            'action'     => 'register',
                            // acl
                            'resource' => 'account',
                            'privilege' => 'register'
                        ),

                        array(
                            'label' => 'Log out',
                            'route' => 'user/default',
                            'controller' => 'log',
                            'action'    => 'out',
                            'resource'  => 'log',
                            'privilege' => 'out'
                        ),
                )
            )
        )
    ),

);
