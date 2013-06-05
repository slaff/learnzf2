<?php
namespace User\Service\Factory;

use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Authentication implements FactoryInterface
{

    public function createService (ServiceLocatorInterface $serviceLocator)
    {
        $adapter = $serviceLocator->get('auth-adapter');

        $auth = new AuthenticationService();
        $auth->setAdapter($adapter);

        return $auth;
    }
}
