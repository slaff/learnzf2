<?php
namespace User\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream as StreamWriter;
use Zend\Log\Filter\Priority as PriorityFilter;

class Log implements FactoryInterface
{
    public function createService (ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        // To start logging we need to create an instance of Zend\Log\Logger
        $log = new Logger();
        // And we must add to the logger at least on writer
        $writer = new StreamWriter('php://stderr');
        $log->addWriter($writer);

        $priority = @$config['log']['priority'];
        if ($priority!==null) {
            $filter = new PriorityFilter($priority);
            $writer->addFilter($filter);
        }
        return $log;
    }
}
