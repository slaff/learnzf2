<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\EventManager\EventManager;

class LogController extends AbstractActionController
{

    public function outAction()
    {
        $auth = $this->serviceLocator->get('auth');
        $auth->clearIdentity();
        return $this->redirect()->toRoute('home');
    }

    public function inAction()
    {
        if (!$this->getRequest()->isPost()) {
            // just show the login form
            return array();
        }

        $username = $this->params()->fromPost('username');
        $password = $this->params()->fromPost('password');

        $auth = $this->serviceLocator->get('auth');
        $authAdapter = $auth->getAdapter();
        // below we pass the username and the password to the authentication adapter for verification
        $authAdapter->setIdentity($username);
        $authAdapter->setCredential($password);

        // here we do the actual verification
        $result = $auth->authenticate();
        $isValid = $result->isValid();
        if($isValid) {
            // upon successful validation the getIdentity method returns
            // the user entity for the provided credentials
            $user = $result->getIdentity();

            // @todo: upon successful validation store additional information about him in the auth storage

            $this->flashmessenger()->addSuccessMessage(sprintf('Welcome %s. You are now logged in.',$user->getName()));

            return $this->redirect()->toRoute('user/default', array (
                    'controller' => 'account',
                    'action'     => 'me',
            ));
        } else {
            $event = new EventManager('user');
            $event->trigger('log-fail', $this, array('username'=> $username));

            return array('errors' => $result->getMessages());
        }
    }
}
