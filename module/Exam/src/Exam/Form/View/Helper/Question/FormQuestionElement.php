<?php
namespace Exam\Form\View\Helper\Question;

use Zend\Form\View\Helper\AbstractHelper;
use Exam\Form\Element\Question\QuestionInterface;

class FormQuestionElement extends AbstractHelper 
{
	/**
	 * Invoke helper as functor
	 *
	 * Proxies to {@link render()}.
	 *
	 * @param  ElementInterface|null $element
	 * @return string|FormInput
	 */
	public function __invoke(QuestionInterface $element = null)
	{
		if (!$element) {
			return $this;
		}
	
		return $this->render($element);
	}
	
    /**
     * Render 
     *
     * @param QuestionInterface $element
     * @param array                $options
     * @param array                $selectedOptions
     * @param array                $attributes
     * @return string
     */
    public function render(QuestionInterface $element)
    {   
        $view = $this->getView();
        if ($element instanceof \Exam\Form\Element\Question\FreeText) {
        	$content = $this->view->formFreeText($element);
        }
        else if($element instanceof \Exam\Form\Element\Question\SingleChoice) {
        	$content = $this->view->formSingleChoice($element);
        }
        else {
        	$content = $this->view->formMultipleChoice($element);
        }
        
        return $content;
    }
}