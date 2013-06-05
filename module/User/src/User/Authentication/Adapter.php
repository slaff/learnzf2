<?php
namespace User\Authentication;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Adapter extends AbstractAdapter implements ServiceLocatorAwareInterface
{
    /**
     *
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /* (non-PHPdoc)
     * @see \Zend\Authentication\Adapter\AdapterInterface::authenticate()
     */
    public function authenticate()
    {
        $entityManager = $this->serviceLocator->get('entity-manager');
        $userEntityClassName = get_class($this->serviceLocator->get('user-entity'));

        // We ask the Doctrine 2 entity manager to find a user with the specified email
        $user = $entityManager->getRepository($userEntityClassName)->findOneByEmail($this->identity);
        // And if we have such an user we check if his password is matching
        if ($user && $user->verifyPassword($this->credential)) {
            // upon successful validation we can return the user entity object
            return new Result(Result::SUCCESS, $user);
        }

        return new Result(Result::FAILURE, $this->identity);

    }
    /* (non-PHPdoc)
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

    }

    /* (non-PHPdoc)
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}
