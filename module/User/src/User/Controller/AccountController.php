<?php
namespace User\Controller;

use User\Form\User as UserForm;
use User\Model\User as UserModel;
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
                // You can use the standard way of instantiating a table gateway
                //$model = new UserModel();
                // Or if you have many db tables that do need special treatment of the incoming data
                // you can use the table gateway service
                $model = $this->serviceLocator->get('table-gateway')->get('users');
                $id = $model->insert($form->getData());

                $this->flashmessenger()->addSuccessMessage('User was added successfully.');

                // redirect the user to the view user action
                return $this->redirect()->toRoute('user/default', array (
                        'controller' => 'account',
                        'action'     => 'view',
                        'id'		 => $id
                ));
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
        $result = $this->forward()->dispatch('User\Controller\Account', array(
            'action' => 'add',
        ));

        return $result;
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
        $id = $this->params('id');
        if(!$id) {
            return $this->redirect()->toRoute('user/default', array(
                'controller' => 'account',
                'action' => 'view',
            ));
        }
    }

    public function meAction()
    {
        return array();
    }

    public function deniedAction()
    {
        return array();
    }
}
