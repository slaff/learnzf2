<?php
namespace Exam\Form\View\Helper\Question;

use Zend\Form\View\Helper\FormMultiCheckbox;
use Exam\Form\Element\Question\MultipleChoice;

class FormMultipleChoice extends FormMultiCheckbox {
    /**
     * Render options
     *
     * @param MultiCheckboxElement $element
     * @param array                $options
     * @param array                $selectedOptions
     * @param array                $attributes
     * @return string
     */
    protected function renderOptions(MultipleChoice $element, array $options, array $selectedOptions,
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