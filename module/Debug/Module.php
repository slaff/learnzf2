<?php
namespace Debug;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\EventManager\Event;
use Zend\Mvc\MvcEvent;
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
    
    public function init(ModuleManager $moduleManager)
    {
    	$eventManager = $moduleManager->getEventManager();
    	$eventManager->attach('loadModules.post', array($this, 'loadedModulesInfo'));
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
		$eventManager->attach('dispatch.error', array($this, 'handleError'));
		
		// Below is how we get access to the service manager
		$serviceManager = $e->getApplication()->getServiceManager();
		// Here we start the timer
		$timer = $serviceManager->get('timer');
		$timer->start('mvc-execution');
	
		// And here we attach a listener to the finish event that has to be executed with priority 2
		// The priory here is 2 because listeners with that priority will be executed just before the
		// actual finish event is triggered.
		$eventManager->attach(MvcEvent::EVENT_FINISH, array($this,'getMvcDuration'),2);
		
		$eventManager->attach(MvcEvent::EVENT_RENDER,array($this,'addDebugOverlay'),100);
	}
    
    public function handleError(MvcEvent $event) 
    {
    	$controller = $event->getController();
    	$error      = $event->getParam('error');
    	$exception  = $event->getParam('exception');
    	$message = 'Error:'.$error;
    	if ($exception instanceof \Exception) {
    		$message .= ', Exception('.$exception->getMessage().'): '.
    				$exception->getTraceAsString();
    	}
    		
    	error_log($message);
    		
    }
    
    public function getMvcDuration(MvcEvent $event)
    {
    	// Here we get the service manager
    	$serviceManager = $event->getApplication()->getServiceManager();
    	// Get the already created instance of our timer service
    	$timer = $serviceManager->get('timer');
    	$duration = $timer->stop('mvc-execution');
    	// and finally print the duration
    	error_log("MVC Duration:".$duration." seconds");
    }
    
    public function addDebugOverlay(MvcEvent $event)
    {
    	$viewModel = $event->getViewModel();
    	 
    	$sidebarView = new ViewModel();
    	$sidebarView->setTemplate('debug/layout/sidebar');
    	$sidebarView->addChild($viewModel, 'content');
    	 
    	$event->setViewModel($sidebarView);
    }
}