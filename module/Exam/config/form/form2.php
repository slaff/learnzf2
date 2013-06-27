<?php
return array(
    'info' => array(
        'name' => 'PHP namespaces ',
        'locale' => 'en_US',
        'description' => 'Test your PHP namespace knowledge.',
        'creator' => 1,
        'active' => 1,
        'duration' => 10,
    ),
    'type' => 'form',
    'elements' => array(
        array(
            'spec' => array(
                'type' => 'Exam\Form\Element\Question\SingleChoice',
                'name' => 'q1',
                'options' => array(
                    'value_options' => array(
                        '1' => 'Compile error: in a namespace you cannot declare functions',
                        '2' => '5',
                        '3' => '4',
                        '4' => 'Compile error: you cannot have a function with the same name as a built-in function'
                    ),
                    'question' => 'What is the result from the following code:
<?php
namespace Custom;

function strlen($string)
{
    return \strlen($string)+1;
}

echo strlen(\'test\');
',
                    'answers' => array(
                        '2'
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
                        'phptag' => 'Before the <?php tag',
                        'first' => 'It has to be the first php command. Or after the declare statement.',
                        'everywhere' => 'You can place a namespace declaration everywhere in a PHP file',
                        'events' => 'Only before a class name',
                    ),
                    'question' => 'Where must the namespace declaration be placed?',
                    'answers' => array(
                        'first'
                    )
                )
            )
        ),
        array(
                'spec' => array(
                        'type' => 'Exam\Form\Element\Question\YesNo',
                        'name' => 'q3',
                        'options' => array(
                                'question' => 'You cannot have constants in a namespace. They must be specified in a class.',
                                'answers' => array(
                                        '0'
                                )
                        )
                )
        ),
        array(
                'spec' => array(
                        'type' => 'Exam\Form\Element\Question\SingleChoice',
                        'name' => 'q5',
                        'options' => array(
                                'question' => 'Which of the following answers is correct for the code below:
<?php
namespace Custom;

use Third\\Party\\User;

class form2
{
    public function createFactory ()
    {
        $object = new User();
        return $object;
    }
}',
                                'value_options' => array(
                                        '1' => 'The method createFactory will return instance of Custom\User',
                                        '2' => 'The method createFactory will return instance of Third\\Party\\User',
                                        '3' => 'Compile error.',
                                ),
                                'answers' => array(
                                        '3',
                                )
                        )
                )
        ),
        array(
                'spec' => array(
                        'type' => 'Exam\Form\Element\Question\MultipleChoice',
                        'name' => 'q6',
                        'options' => array(
                                'question' => 'We have a file called User.php with the following code.
<?php
namespace Custom;

class User
{
    public function createFactory ()
    {
        // @todo: complete the code below
        $object = new <fill-the-code>();
        return $object;
    }
}
?>

What can be written in <fill-the-code> to return an instance of the class RegisteredUser in the same namespace as the User class.        				    '
                            ,
                                'value_options' => array(
                                        '1' => 'RegisteredUser',
                                        '2' => '\Custom\RegistedUser',
                                        '3' => 'Custom\RegistedUser',
                                        '4' => '\Global\Custom\RegistedUser',
                                ),
                                'answers' => array(
                                        '1','2'
                                )
                        )
                )
        ),
    )
);
