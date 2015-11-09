<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Exam\Controller\Test' => 'Exam\Controller\TestController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'exam' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/exam',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Exam\Controller',
                        'controller'    => 'Test',
                        'action'        => 'index',
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
            'Exam' => __DIR__ . '/../view',
        ),
    ),
	'view_helpers' => array (
		'invokables' => array (
			'formMultipleChoice'  => 'Exam\Form\View\Helper\Question\FormMultipleChoice',
			'formSingleChoice'    => 'Exam\Form\View\Helper\Question\FormSingleChoice',
			'formFreeText'   	  => 'Exam\Form\View\Helper\Question\FormFreeText',
			'formQuestionElement' => 'Exam\Form\View\Helper\Question\FormQuestionElement',
		)
	),
);
