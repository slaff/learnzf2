<?php
namespace User\Controller;

use User\Form\User as UserForm;
use Zend\Mvc\Controller\AbstractActionController;

class AccountController extends AbstractActionController 
{
	public function indexAction() 
	{
		return array();
	}

	public function addAction()
    {
        $form = new UserForm();
        if($this->getRequest()->isPost()) {
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                // Notice: make certain to merge the Files also to the post data
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($data);
            if($form->isValid()) {
            	// @todo: save the data of the new user 
            }
        }
        
        // pass the data to the view for visualization
        return array('form1'=> $form);
    }

	/*
	 * Anonymous users can use this action to register new accounts
	 */
	public function registerAction() 
	{
		return array();
	}

	public function viewAction() 
	{
		return array();
	}

	public function editAction() 
	{
		return array();
	}

	public function deleteAction() 
	{
		return array();
	}
}
