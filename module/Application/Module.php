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
use Zend\View\Model\ViewModel;

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

            $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this,'getActionCache'), 2);
            $eventManager->attach(MvcEvent::EVENT_RENDER, array($this,'saveActionCache'), 0);
        }

        if($services->has('cache')) {
            $config = $services->get('config');
            $cache  = $services->get('var-cache');

            // Enables cache for services
            if(isset($config['cache-enabled-services'])) {
                foreach($config['cache-enabled-services'] as $serviceName) {
                    if($services->has($serviceName)) {
                        $services->get($serviceName)->setCache($cache);
                    }
                }
            }

            // Enables cache for classes
            if(isset($config['cache-enabled-classes'])) {
                foreach($config['cache-enabled-classes'] as $className) {
                    call_user_func($className.'::setCache', $cache);
                }
            }
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
            $tags = $match->getParam('tags');
            if (is_array($tags)) {
                $cache->setTags($cacheKey, $tags);
            }
        }
    }

    // Action cache implementation
    public function getActionCache(MvcEvent $event)
    {
        $match = $event->getRouteMatch();
        if(!$match) {
            return;
        }

        if($match->getParam('actioncache')) {
            $cache = $event->getApplication()->getServiceManager()->get('text-cache');
            $cacheKey = $this->actionCacheKey($match);
            $data = $cache->getItem($cacheKey);
            if(null !== $data) {
                // When data comes from the cache
                // we don't want the saveActionCache method to refresh this cache
                $match->setParam('actioncache',false);

                $viewModel = $event->getViewModel();
                $viewModel->setVariable($viewModel->captureTo(), $data);
                $event->stopPropagation(true);
                return $viewModel;
            }
        }
    }

    public function saveActionCache(MvcEvent $event)
    {
        $match = $event->getRouteMatch();
        if(!$match) {
            return;
        }

        if($match->getParam('actioncache')) {
            $viewManager = $event->getApplication()->getServiceManager()->get('viewmanager');

            $result    = $event->getResult();
            if($result instanceof ViewModel) {
                $cache = $event->getApplication()->getServiceManager()->get('text-cache');
                // Warning: The line below needs improvement. It will work for all PHP templates, but have
                //		    to be made more flexible if you plan to use other template systems.
                $renderer = $viewManager->getRenderer();

                $content = $renderer->render($result);
                $cacheKey = $this->actionCacheKey($match);
                $cache->setItem($cacheKey, $content);
                $tags = $match->getParam('tags');
                if (is_array($tags)) {
                    $cache->setTags($cacheKey, $tags);
                }
            }
        }
    }

    /**
     * Generates valid page cache key
     *
     * @param RouteMatch $match
     * @param string $prefix
     * @return string
     */
    protected function pageCacheKey(RouteMatch $match, $prefix='pagecache_')
    {
        return  $prefix.str_replace('/','-',$match->getMatchedRouteName()).'_'.md5(serialize($match->getParams()));
    }

    /**
     * Generates valid action cache key
     *
     * @param RouteMatch $match
     * @param string $prefix
     * @return string
     */
    protected function actionCacheKey(RouteMatch $match, $prefix='actioncache_')
    {
        return $this->pageCacheKey($match, $prefix);
    }
}
