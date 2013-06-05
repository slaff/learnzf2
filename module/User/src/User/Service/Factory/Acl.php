<?php
namespace User\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Permissions\Acl\Acl as AccessControlList;

class Acl implements FactoryInterface
{
    public function createService (ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $aclConfig = $config['acl'];

        $acl  = new AccessControlList();
        // add the defined resources
        foreach($aclConfig['resource'] as $resource=>$parent) {
            $acl->addResource($resource, $parent);
        }

        // add the defined roles
        foreach($aclConfig['role'] as $role=>$parents) {
            $acl->addRole($role, $parents);
        }

        // add the allow and deny definitions
        foreach (array('allow','deny') as $action) {
            foreach($aclConfig[$action] as $definition) {
                call_user_func_array(array($acl,$action), $definition);
            }
        }

        return $acl;
    }
}
