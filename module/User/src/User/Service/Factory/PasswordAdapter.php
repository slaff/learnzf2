<?php
namespace User\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Crypt\Password\Bcrypt;

class PasswordAdapter implements FactoryInterface
{
    public function createService (ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        // Notice: In order for the code below to work make sure that you have copied
        // the module/Application/config/crypto.local.php.dist file to config/autoload/crypto.local.php .
        $adapter = new Bcrypt($config['bcrypt']);

        return $adapter;
    }
}
