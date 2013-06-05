<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $services = $e->getApplication()->getServiceManager();
        if($services->has('text-cache')) {
            // This will be used to check if there is already cached page and return it.
            // The priority must be low in order to be executed after the routing is done
            $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this,'getPageCache'), -1000);
            // And this will be used to save a generated cache page.
            // The priority must be low in order to be executed after the rendering is done
            $eventManager->attach(MvcEvent::EVENT_RENDER, array($this,'savePageCache'), -10000);
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getPageCache(MvcEvent $event)
    {
        $match = $event->getRouteMatch();
        if(!$match) {
            return;
        }

        if($match->getParam('pagecache')) {
            // the page can be cached so lets check if we have a cache copy of it
            $cache = $event->getApplication()->getServiceManager()->get('text-cache');
            $cacheKey = $this->pageCacheKey($match);
            $data = $cache->getItem($cacheKey);
            if(null !== $data) {
                $response = $event->getResponse();
                $response->setContent($data);

                // When we return a response object we actually shortcut the execution and the action responsible
                // for this page is not be executed
                return $response;
            }
        }
    }

    public function savePageCache(MvcEvent $event)
    {
        $match = $event->getRouteMatch();
        if(!$match) {
            return;
        }

        if($match->getParam('pagecache')) {
            $response = $event->getResponse();
            $data = $response->getContent();
            $cache = $event->getApplication()->getServiceManager()->get('text-cache');
            $cacheKey = $this->pageCacheKey($match);
            $cache->setItem($cacheKey, $data);
        }
    }

    /**
     * Generates valid page cache key
     *
     * @param RouteMatch $match
     * @return string
     */
    protected function pageCacheKey(RouteMatch $match)
    {
        return  'pagecache_'.str_replace('/','-',$match->getMatchedRouteName()).'_'.md5(serialize($match->getParams()));
    }

}
