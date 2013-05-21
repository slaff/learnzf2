<?php
namespace Exam\Form\View\Helper\Question;

use Zend\Form\View\Helper\FormText;
use Exam\Form\Element\Question\FreeText;

class FormFreeText extends FormText {
    /**
     * Render 
     *
     * @param MultiCheckboxElement $element
     * @param array                $options
     * @param array                $selectedOptions
     * @param array                $attributes
     * @return string
     */
    public function render(FreeText $element)
    {   
        $question = $element->getQuestion();
        $header   = $element->getHeader();
        
        $content  = "<dd><pre>".$this->getView()->escapeHtml($question)."</pre></dd>";
        $content .= "<dl>$header</dl>";
        $content .= parent::render($element);
        
        return $content;
    }
}