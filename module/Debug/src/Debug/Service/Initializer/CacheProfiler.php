<?php
namespace Debug\Service\Initializer;

use Zend\Cache\Storage\Event;
use Zend\Cache\Storage\StorageInterface;
use Zend\Cache\Storage\PostEvent;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CacheProfiler implements InitializerInterface
{
    /**
     * @var \stdClass
     */
    protected $stats;

    /**
     * @var ServiceLocatorInterface
     */
    protected $services;

    /**
     * Initialize
     *
     * @param $instance
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof StorageInterface) {
            // Every cache service has its own event manager
            $cacheEventManager = $instance->getEventManager();
            // And we can liste to getItem.pre and getItem.post events
            // to find out if we have cache hit or cache miss.
            $cacheEventManager->attach('getItem.pre' ,array($this, 'preGetCache'));
            $cacheEventManager->attach('getItem.post',array($this,'postGetCache'));
            if(!$this->stats) {
                // Because we want to be able to access the counter from the Module class
                // we can store the information into a service called cache-profile
                $stats = new \stdClass();
                $stats->hits = array();
                $serviceLocator->setService('cache-profiler', $stats);
                $this->stats = $stats;
                $this->services = $serviceLocator;
            }
        }
    }

    public function preGetCache(Event $event)
    {
        $key = $event->getParam('key');
        if(!isset($this->stats->hits[$key])) {
            $this->stats->hits[$key] = 0;
        }
    }

    public function postGetCache(PostEvent $event)
    {
        $key = $event->getParam('key');
        if(null !== $event->getResult()) {
            // if we have a hit we increment the counter
            $this->stats->hits[$key]++;
        }
    }
}
