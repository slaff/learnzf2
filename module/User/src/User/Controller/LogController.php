<?php 
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class LogController extends AbstractActionController
{

    public function outAction()
    {	
    	return $this->redirect()->toRoute('home');
    }
   
    public function inAction() 
    {
        if (!$this->getRequest()->isPost()) 
        {
            // just show the login form
            return array();
        }
       
        $username = $this->params()->fromPost('username');
        $password = $this->params()->fromPost('password');
        
        // @todo: When the authentication is implemented the hard-coded value below has to be removed.
        $isValid = 1;
        if($isValid) {
        	$this->flashmessenger()->addSuccessMessage('You are now logged in.');
        	 
        	return $this->redirect()->toRoute('user/default', array (
        			'controller' => 'account',
        			'action'     => 'me',
        	));
        }
        else {
        	// @todo: report some errors
        }
    }
}