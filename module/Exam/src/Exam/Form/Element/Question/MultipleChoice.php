<?php
namespace Exam\Form\Element\Question;

use Zend\Form\Element\MultiCheckbox;
use Zend\Validator\ValidatorInterface;
use Zend\Form\Exception\InvalidArgumentException;
use Zend\Validator\Callback;

class MultipleChoice extends MultiCheckbox implements QuestionInterface
{
    protected $question;
    protected $answers;
    protected $header = 'Only %d of the following answers %s correct.';
    protected $maxAnswers = null;
    
    /**
     * Specifies the question
     * @param string $text
     */
	public function setQuestion($text) 
	{
	    $this->question = $text;    	
	}
	
	/**
	 * Specifies the header text
	 * @param string $text
	 */
	public function setHeader($text) 
	{
	    $this->header = $text;	
	}
	
	/** Gets the question text
	 * @return string
	 */
	public function getQuestion() 
	{
		return $this->question;
	}

	/** Gets the question header
	 * @return string
	 */
    public function getHeader() 
    {
        $count = count($this->answers);
    	return sprintf($this->header, $count, $count>1?'are':'is');
    }
	
	/**
	 * Sets the answer(s)
	 * @param array|string $answers
	 */
	public function setAnswers($answers) 
	{
	    $answers = (array)$answers;
	    if (empty($answers) || (null !== $this->maxAnswers && count($answers) > $this->maxAnswers)) {
	    	throw new InvalidArgumentException('Invalid number of correct answers');
	    }
	    
		$this->answers = $answers;
	}
	
	/**
	 * Gets the list of answers
	 * @return array
	 */
	public function getAnswers() 
	{
		return $this->answers;
	}
	
	/**
	 * Get validator
	 *
	 * @return ValidatorInterface
	 */
	protected function getValidator()
	{
		if (null === $this->validator) {
		    $answers = $this->getAnswers();
		    // Example: Custom Validator Via Callback
		    $this->validator = new Callback(function($value) use ($answers) {
		    	$diff = array_diff($answers, (array)$value);
		    	if(!empty($diff)) {
		    		return false;
		    	}
		    	return true;
		    });
		}
		return $this->validator;
	}
	
	/**
	 * Set options for an element. Accepted options are:
	 * - label: label to associate with the element
	 * - label_attributes: attributes to use when the label is rendered
	 * - value_options: list of values and labels for the select options
	 *
	 * @param  array|\Traversable $options
	 * @return MultiCheckbox|ElementInterface
	 * @throws InvalidArgumentException
	 */
	public function setOptions($options)
	{
		parent::setOptions($options);
	
		if (isset($this->options['question'])) {
			$this->setQuestion($this->options['question']);
		}
		if (isset($this->options['header'])) {
			$this->setHeader($this->options['header']);
		}
	    if (isset($this->options['answers'])) {
			$this->setAnswers($this->options['answers']);
		}
	
		return $this;
	}

}