<?php
return array(
    'info' => array(
        'name' => 'ZF2 test',
        'locale' => 'en_US',
        'description' => 'Test your Zend Framework 2 knowledge.',
        'creator' => 1,
        'active' => 1,
        'duration' => 20,
    ),
    'type' => 'form',
    'elements' => array(
        array(
            'spec' => array(
                'type' => 'Exam\Form\Element\Question\SingleChoice',
                'name' => 'q1',
                'options' => array(
                    'value_options' => array(
                        '1' => 'module/',
                        '2' => 'vendor/',
                        '3' => 'data/',
                        '4' => 'application/'
                    ),
                    'question' => 'What is the best directory to create your own modules?',
                    'answers' => array(
                        '1'
                    )
                )
            )
        ),
        array(
            'spec' => array(
                'type' => 'Exam\Form\Element\Question\SingleChoice',
                'name' => 'q2',
                'options' => array(
                    'value_options' => array(
                        'twitter'     => 'to allow talking to remote services like Twitter',
                        'os'          => 'to manage operation system services(aka daemons)',
                        'holdobjects' => 'to create and hold various objects needed by your application',
                        'events'      => 'to enable event synchronization',
                    ),
                    'question' => 'What is the purpose of the Service Manager?',
                    'answers' => array(
                        'holdobjects'
                    )
                )
            )
        ),
        array(
                'spec' => array(
                        'type' => 'Exam\Form\Element\Question\YesNo',
                        'name' => 'q3',
                        'options' => array(
                                'question' => 'A module without controllers is valid.',
                                'answers' => array(
                                        '1'
                                )
                        )
                )
        ),
        array(
                'spec' => array(
                        'type' => 'Exam\Form\Element\Question\YesNo',
                        'name' => 'q4',
                        'options' => array(
                                'question' => 'A module without a Module.php file is valid',
                                'answers' => array(
                                        '0'
                                )
                        )
                )
        ),
        array(
                'spec' => array(
                        'type' => 'Exam\Form\Element\Question\MultipleChoice',
                        'name' => 'q5',
                        'options' => array(
                                'question' => 'Which components/packages can you use to make database requests?',
                                'value_options' => array(
                                        '1' => 'Zend\Db',
                                        '2' => 'Doctrine 2',
                                        '3' => 'ZendPdf',
                                        '4' => 'Zend\TableGateway'
                                ),
                                'answers' => array(
                                        '1','2'
                                )
                        )
                )
        ),
        array(
                'spec' => array(
                        'type' => 'Exam\Form\Element\Question\MultipleChoice',
                        'name' => 'q6',
                        'options' => array(
                                'question' => 'Which version(s) of PHP is ZF2 compatible with?',
                                'value_options' => array(
                                        '1' => 'PHP 5.2.*',
                                        '2' => 'PHP 5.3.*',
                                        '3' => 'PHP >=5.3.3',
                                        '4' => 'PHP 5.4.*'
                                ),
                                'answers' => array(
                                        '3','4'
                                )
                        )
                )
        ),
        array(
                'spec' => array(
                        'type' => 'Exam\Form\Element\Question\FreeText',
                        'name' => 'q7',
                        'options' => array(
                                'question' => 'Which event method causes pending event listeners for current event to not be executed?',
                                'answers' => array(
                                        'stopPropagation'
                                )
                        )
                )
        ),
        array(
                'spec' => array(
                        'type' => 'Exam\Form\Element\Question\MultipleChoice',
                        'name' => 'q8',
                        'options' => array(
                                'question' => 'On which web server can you run a ZF2 application?',
                                'value_options' => array(
                                        '1' => 'Only Apache',
                                        '2' => 'Only Nginx',
                                        '3' => 'Only Zend Server',
                                        '4' => 'on any server that is capable of running PHP'
                                ),
                                'answers' => array(
                                        '4'
                                )
                        )
                )
        ),
        array(
                'spec' => array(
                        'type' => 'Exam\Form\Element\Question\SingleChoice',
                        'name' => 'q9',
                        'options' => array(
                                'question' => 'Can you use ZF2 components separately?',
                                'value_options' => array(
                                        '1' => 'No, you need the complete ZF2 skeleton application',
                                        '2' => 'Not really. You always need the Zend\Mvc component',
                                        '3' => 'Yes, you may need to run composer to fetch dependent components, if any',
                                        '4' => 'Yes, but only in Doctrine 2 applications'
                                ),
                                'answers' => array(
                                        '3'
                                )
                        )
                )
        ),
        array(
                'spec' => array(
                        'type' => 'Exam\Form\Element\Question\MultipleChoice',
                        'name' => 'q10',
                        'options' => array(
                                'question' => 'From where can you trigger events?',
                                'value_options' => array(
                                        '4' => 'From everywhere in your application',
                                        '1' => 'Only from controllers',
                                        '2' => 'Only from models',
                                        '3' => 'From controllers, models and views',
                                ),
                                'answers' => array(
                                        '4'
                                )
                        )
                )
        ),
    )
);
