<?php
namespace UserTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AccountControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    public function setUp()
    {
        $this->setApplicationConfig(
                include __DIR__.'/../../config/application.config.php'
        );
        parent::setUp();
    }

    public function testMeAction()
    {
        $application = $this->getApplication();
        $serviceManager = $application->getServiceManager();
        $eventManager   = $application->getEventManager();

        // This is how the request object can be accessed and modified.
        $request = $this->getRequest();

        $user = $serviceManager->get('user');
        $config = $serviceManager->get('config');
        $user->setRole($config['acl']['defaults']['member_role']);

        // The dispatch method returns the result.
        $result = $this->dispatch('/user/account/me');


        $this->assertActionName('me');
        $this->assertControllerName('User\Controller\Account');

        // This is how the response object can be accessed.
        $response = $this->getResponse();

        // And here we can use the response to check the status code.
        $this->assertEquals(200, $response->getStatusCode());
    }
}
