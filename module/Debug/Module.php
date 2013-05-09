<?php
namespace Debug;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\ModuleEvent;
use Zend\EventManager\Event;
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
    
    public function init(ModuleManager $moduleManager)
    {
    	$eventManager = $moduleManager->getEventManager();
    	$eventManager->attach(ModuleEvent::EVENT_LOAD_MODULES_POST, array($this, 'loadedModulesInfo'));
    }
    
    public function loadedModulesInfo(Event $event)
    {
    	$moduleManager = $event->getTarget();
    	$loadedModules = $moduleManager->getLoadedModules();
    	error_log(var_export($loadedModules, true));
    }

	public function onBootstrap(MvcEvent $e)
	{
		$eventManager        = $e->getApplication()->getEventManager();
		$eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleError'));
	}
    
    public function handleError(MvcEvent $event) {
    	$controller = $event->getController();
    	$error      = $event->getParam('error');
    	$exception  = $event->getParam('exception');
    	$message = sprintf('Error dispatching controller "%s". Error was: "%s"', $controller, $error);
    	if ($exception instanceof \Exception) {
    		$message .= ', Exception('.$exception->getMessage().'): '.
    				$exception->getTraceAsString();
    	}
    		
    	error_log($message);
    		
    }
}
