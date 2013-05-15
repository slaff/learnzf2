<?php
namespace Application\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Crypt\BlockCipher;

class SymmetricCipher implements FactoryInterface
{
    public function createService (ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $blockCipher = BlockCipher::factory($config['cipher']['adapter'], $config['cipher']['options']);
        $blockCipher->setKey($config['cipher']['encryption_key']);
        
        return $blockCipher;
    }
}
