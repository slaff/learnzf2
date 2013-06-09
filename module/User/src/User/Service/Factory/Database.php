<?php
namespace User\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\ServiceManager\ServiceLocatorInterface;

class Database implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $adapter = new DbAdapter($config['db']);
        return $adapter;
    }
}
