<?php
namespace Exam\Form\Element\Question;

class YesNo extends SingleChoice
{
    protected $header = 'Is this correct?';
    
    public function init() 
    {  
        parent::setValueOptions(array(
            '0' => 'No',
            '1' => 'Yes',
        ));
    }
    
    /**
     * @param  array $options
     * @return MultiCheckbox
     */
    public function setValueOptions(array $options)
    {
        throw new \Exception('This method is not allowed');
    }
    
    /**
     * Set options for an element. Accepted options are:
     * - label: label to associate with the element
     * - label_attributes: attributes to use when the label is rendered
     *
     * @param  array|\Traversable $options
     * @return YesNo|ElementInterface
     * @throws InvalidArgumentException
     */
    public function setOptions($options)
    {
    	parent::setOptions($options);
    	return $this;
    }
}