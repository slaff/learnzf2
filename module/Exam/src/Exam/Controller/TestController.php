<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Exam for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Exam\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Exam\Form\Element\Question\QuestionInterface;
use Exam\Model\Test;

class TestController extends AbstractActionController
{
    public function indexAction()
    {
        return array();
    }

    public function takeAction()
    {
    	$id = $this->params('id');
        if(!$id) {
        	return $this->redirect()->toRoute('exam/list');
        }
        
        $testManager = $this->serviceLocator->get('test-manager');
        $form = $testManager->createForm($id);
        
        $form->setAttribute('method', 'POST');
         
        $form->add(array(
        		'type' => 'Zend\Form\Element\Csrf',
        		'name' => 'security',
        ));
         
        $form->add(array(
        		'type' => 'submit',
        		'name' => 'submit',
        		'attributes' => array (
        				'value' => 'Ready',
        		)
        ));
        
        if ($this->getRequest()->isPost()) {
        	// If we have post request -> check how many correct answers are correct
        	$data = $this->getRequest()->getPost();
        	$form->setData($data);
        	$correct = 0;
        	$total   = 0;
        	if($form->isValid()) { 
        		// All answers were answered correctly.
        		$this->flashmessenger()->addSuccessMessage('Great! You have 100% correct answers.');
        		// @todo: trigger an event in that case
        	}
        	else {
        		// Check how many answers were correct using validation groups for partial validation.
        		foreach ($form as $element) {
        			if ($element instanceof QuestionInterface) {
        				$total++;
        				$form->setValidationGroup($element->getName());
        				$form->setData($data);
        				if ($form->isValid()) {
        					$correct++;
        				}
        			}
        		}
        
        		if(!$correct) {
        			$this->flashmessenger()->addErrorMessage('You failed. That is sad but you can try again.');
        		}
        		else {
        			$this->flashmessenger()->addMessage(sprintf('Correct %d out of total %d',$correct, $total));
        		}
        
        	}
        
        	return $this->redirect()->toRoute('exam/list');
        }
        
        
        return array('form' => $form);
    }
    
    /**
     * Deletes all tests in the database and adds the default ones.
     */
    public function resetAction()
    {
    	$model = new Test();
    	$model->delete(array());
    	 
    	// fill the default tests
    	$manager = $this->serviceLocator->get('test-manager');
    	$tests = $manager->getDefaultTests();
    	foreach ($tests as $test) {
    		$data = $test['info'];
    		$data['definition'] = json_encode($test);
    		$manager->store($data);
    	}
    	 
    	$this->flashmessenger()->addSuccessMessage('The default tests were added');
    	return $this->redirect()->toRoute('exam/list');
    }
    
}
