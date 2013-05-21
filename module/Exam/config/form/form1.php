<?php
$i = 0;
return array(
    'info' => array(
        'name' => 'PHP 5 test',
        'locale' => 'en_US',
        'description' => 'Test your PHP 5 knowledge.',
        'creator' => 1,
        'active' => 1,
        'duration' => 10,
    ),
    'type' => 'form',
    'elements' => array(
    	array(
    		'spec' => array(
    			'type' => 'Exam\Form\Element\Question\SingleChoice',
    			'name' => 'q'.++$i,
    			'options' => array(
    				'value_options' => array(
    					'namespaces' => 'namespaces',
    					'classes' => 'classes',
    					'traits' => 'traits',
    					'multi' => 'multiple inheritance'
    				),
    				'question' => 'What is new in PHP 5.4',
    				'answers' => array(
    					'traits'
    				)
    			)
    		)
    	),
    	array(
    		'spec' => array(
    			'type' => 'Exam\Form\Element\Question\FreeText',
    			'name' => 'q'.++$i,
    			'options' => array(
    				'question' => 'Which predifined constant will give you the current namespace?',
    				'answers' => array(
    					'__namespace__'
    				)
    			)
    		)
    	),
        array(
    		'spec' => array(
    				'type' => 'Exam\Form\Element\Question\SingleChoice',
    				'name' => 'q'.++$i,
    				'options' => array(
    						'question' => 'What is the result from the following code?
<?php
$name="tAtIaNa";

switch(strtolower($name)) {
    case "tat"."ia"."na":
        echo "tat";
    case "angela":
        echo "ang";
        
    case  array(1):
        echo "Arr";
        
    case "bard":
        echo "bar";
        break;

    default:
        echo "sonia";
}
?>',
        				    'value_options' => array(
        				    	'error' => 'Error - you cannot use array(1) in the case statement',
        				    	'sonia' => 'Text: sonia',
        				        'angbartat' => 'Text: tat',
        				        'tatangArrbar' => 'Text: tatangArrbar',
        				    ),
    						'answers' => array(
    								'tatangArrbar'
    						)
    				)
    		)
        ),
        array(
        		'spec' => array(
        				'type' => 'Exam\Form\Element\Question\SingleChoice',
        				'name' => 'q'.++$i,
        				'options' => array(
        						'question' => "What is the result from the following code?
<?
class A {
	public function get(){
		return \$this->getValue();
	}

	protected function getValue() {
		return 5;
	}
}

class B extends A {

	private function getValue() {
		return 10;
	}
}


\$object = new B();
echo \$object->get();
?>        				    
        				    ",
        				    'value_options' => array(
        				    		'compile-error' => 'Compile error - method getValue in class B can not be declared as private. 
Public and protected are allowed.',
        				    		'10' => '10',
        				    		'5' => '5',
        				    		'error' => 'Run-time error: method get is not defined in class B and cannot be called.',
        				    ),
        					'answers' => array(
        					        'compile-error'
        					)
        				)
        		)
        ),
        array(
        		'spec' => array(
        				'type' => 'Exam\Form\Element\Question\FreeText',
        				'name' => 'q'.++$i,
        				'options' => array(
        						'question' => 'What is the result from the code below:
<?php

class MyException extends Exception {
}
function bad()
{
	try {
		throw new MyException("Something bad happened");
	} catch (NonExistentException $e) {
		echo "What?";
	}
}

try {
	bad();
} catch (MyException $e) {
	echo "Bad!";
} catch (Exception $e) {
	echo "Oops!";
}
	
echo $e instanceof NonExistentException ? 1: 0;
?>',
        						'answers' => array(
        								'bad!0'
        						)
        				)
        		)
        ),
        
    )
);