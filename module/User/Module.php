<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/User for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\Exception\ExceptionInterface as AclException;
use Zend\EventManager\EventManager;
use Zend\View\Model\ViewModel;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
            // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event)
    {
        $services = $event->getApplication()->getServiceManager();
        $dbAdapter = $services->get('database');
        \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::setStaticAdapter($dbAdapter);

        $eventManager = $event->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'protectPage'), -100);

        $sharedEventManager = $event->getApplication()->getEventManager()->getSharedManager();
        $sharedEventManager->attach('user','log-fail', function($event) use ($services) {
            $username = $event->getParam('username');

            $log = $services->get('log');
            $log->warn('Error logging user ['.$username.']');
        });

        $sharedEventManager->attach('user','register', function($event) use ($services) {
            $user= $event->getParam('user');

            $log = $services->get('log');
            $log->warn('Registered user ['.$user->getName().'/'.$user->getId().']');
        });

        $eventManager->attach('render', array($this, 'injectUserAcl'));
    }

    public function protectPage(MvcEvent $event)
    {
        $match = $event->getRouteMatch();
        if(!$match) {
            // we cannot do anything without a resolved route
            return;
        }

        $controller = $match->getParam('controller');
        $action     = $match->getParam('action');
        $namespace  = $match->getParam('__NAMESPACE__');

        $parts           = explode('\\', $namespace);
        $moduleNamespace = $parts[0];

        $services = $event->getApplication()->getServiceManager();
        $config = $services->get('config');

        $auth     = $services->get('auth');
        $acl      = $services->get('acl');

        // get the role of the current user
        $currentUser = $services->get('user');
        $role = $currentUser->getRole();

        // This is how we add default acl and role to the navigation view helpers
        \Zend\View\Helper\Navigation\AbstractHelper::setDefaultAcl($acl);
        \Zend\View\Helper\Navigation\AbstractHelper::setDefaultRole($role);

        // check if the current module wants to use the ACL
        $aclModules = $config['acl']['modules'];
        if (!empty($aclModules) && !in_array($moduleNamespace, $aclModules)) {
            return;
        }

        // Get the short name of the controller and use it as resource name
        // Example: User\Controller\Course -> course
        $resourceAliases = $config['acl']['resource_aliases'];
        if (isset($resourceAliases[$controller])) {
            $resource = $resourceAliases[$controller];
        } else {
            $resource = strtolower(substr($controller, strrpos($controller,'\\')+1));
        }

        // If a resource is not in the ACL add it
        if(!$acl->hasResource($resource)) {
            $acl->addResource($resource);
        }
        try {
            if($acl->isAllowed($role, $resource, $action)) {
                return;
            }
        } catch(AclException $ex) {
            // @todo: log in the warning log the missing resource
        }

        // If the role is not allowed access to the resource we have to redirect the
        // current user to the log in page.
        $e = new EventManager('user');
        $e->trigger('deny', $this, array(
                                          'match' => $match,
                                          'role'  => $role,
                                          'acl'   =>$acl
                                       )
                );

        // Set the response code to HTTP 403: Forbidden
        $response = $event->getResponse();
        $response->setStatusCode(403);
        // and redirect the current user to the denied action
        $match->setParam('controller', 'User\Controller\Account');
        $match->setParam('action', 'denied');
    }

    public function injectUserAcl(MvcEvent $event)
    {
        if(!$event->getResponse()->contentSent()) {
            $services = $event->getApplication()->getServiceManager();
            $viewModel = $event->getResult();
            if($viewModel instanceof ViewModel) {
                $viewModel->setVariable('user', $services->get('user'));
                $viewModel->setVariable('acl', $services->get('acl'));
            }
        }
    }
}
