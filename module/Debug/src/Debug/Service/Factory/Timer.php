<?php
namespace Debug\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Debug\Service\Timer as TimerService;

class Timer implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $timer = new TimerService();
        return $timer;
    }
}
