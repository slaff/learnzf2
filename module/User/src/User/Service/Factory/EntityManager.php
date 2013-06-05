<?php
namespace User\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Doctrine\Common\EventArgs;

class EntityManager implements FactoryInterface
{
    public function createService (ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        // The parameters in Doctrine 2 and ZF2 are slightly different.
        // Below is an example how we can reuse the db settings
        $doctrineDbConfig = (array)$config['db'];
        $doctrineDbConfig['driver'] = strtolower($doctrineDbConfig['driver']);
        if(!isset($doctrineDbConfig['dbname'])) {
            $doctrineDbConfig['dbname']  = $doctrineDbConfig['database'];
        }
        if (!isset($doctrineDbConfig['host'])) {
            $doctrineDbConfig['host'] = $doctrineDbConfig['hostname'];
        }
        if (!isset($doctrineDbConfig['user'])) {
            $doctrineDbConfig['user']   = $doctrineDbConfig['username'];
        }
        $doctrineConfig = Setup::createAnnotationMetadataConfiguration($config['doctrine']['entity_path'], true);
        $entityManager = DoctrineEntityManager::create($doctrineDbConfig, $doctrineConfig);

        if(isset($config['doctrine']['initializers'])) {
            $eventManager = $entityManager->getEventManager();

            foreach ($config['doctrine']['initializers'] as $initializer) {
                $eventClass = new DoctrineEvent(new $initializer(), $serviceLocator);
                $eventManager->addEventListener(\Doctrine\ORM\Events::postLoad, $eventClass);
            }
        }

        if($serviceLocator->has('doctrine-profiler')) {
            $profiler = $serviceLocator->get('doctrine-profiler');
            $entityManager->getConfiguration()->setSQLLogger($profiler);
        }

        return $entityManager;
    }
}

class DoctrineEvent
{
    protected $initializer;

    public function __construct($initializer, $serviceLocator)
    {
        $this->initializer = $initializer;
        $this->serviceLocator = $serviceLocator;
    }
    public function postLoad(EventArgs $event)
    {
        $entity = $event->getEntity();
        $this->initializer->initialize($entity, $this->serviceLocator);
    }
}
