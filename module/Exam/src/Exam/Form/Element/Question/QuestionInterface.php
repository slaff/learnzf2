<?php
namespace Exam\Form\Element\Question;

interface QuestionInterface 
{
    /**
     * Specifies the question
     * @param string $text
     */
	public function setQuestion($text);
	
	/** Gets the question text
	 * @return string
	*/
	public function getQuestion();
	
	/**
	 * Specifies the header text
	 * @param string $text
	 */
	public function setHeader($text);
	
	/** Gets the question header
	 * @return string
	 */
	public function getHeader(); 
	
	/**
	 * Sets the answer(s)
	 * @param array|string $answers
	 */
	public function setAnswers($answers);
}
