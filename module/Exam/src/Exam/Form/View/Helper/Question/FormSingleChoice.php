<?php
namespace Exam\Form\View\Helper\Question;

use Zend\Form\View\Helper\FormRadio;
use Exam\Form\Element\Question\SingleChoice;

class FormSingleChoice extends FormRadio {
    /**
     * Render options
     *
     * @param MultiCheckboxElement $element
     * @param array                $options
     * @param array                $selectedOptions
     * @param array                $attributes
     * @return string
     */
    protected function renderOptions(SingleChoice $element, array $options, array $selectedOptions,
    		array $attributes)
    {   
        $question = $element->getQuestion();
        $header   = $element->getHeader();
        
        $content  = "<dd><pre>".$this->getView()->escapeHtml($question)."</pre></dd>";
        $content .= "<dl>$header</dl>";
        $content .= parent::renderOptions($element, $options, $selectedOptions, $attributes);
        
        return $content;
    }
}