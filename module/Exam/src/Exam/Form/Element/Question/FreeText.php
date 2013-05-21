<?php
namespace Exam\Form\Element\Question;

class FreeText extends SingleChoice
{	
	protected $header = 'Enter the answer in the text field';
	
    /**
     * (non-PHPdoc)
     * @see \Exam\Form\Element\Question\MultipleChoice::setAnswers()
     */
    public function setAnswers($answers) 
    {
    	parent::setAnswers($answers);
    	foreach($this->answers as &$answer) {
    		$answer = strtolower($answer);
    	}
    }
    
    /**
     * Provide default input rules for this element.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        return array(
            'name' => $this->getName(),
            'required' => true,
            'filters' => array(
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StringToLower'),
            ),
            'validators' => array(
                $this->getValidator(),
            ),
        );
    }	
}