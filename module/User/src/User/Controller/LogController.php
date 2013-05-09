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
    }
}