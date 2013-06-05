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

        $services = $event->getApplication()->getServiceManager();
        $auth = $services->get('auth');
        if (!$auth->hasIdentity()) {
            // Set the response code to HTTP 401: Auth Required
            $response = $event->getResponse();
            $response->setStatusCode(401);

            $match->setParam('controller', 'User\Controller\Log');
            $match->setParam('action', 'in');
        }
    }
}
