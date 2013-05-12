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
    	$this->dispatch('/user/account/me');
    	 
    	$this->assertActionName('me');
    	$this->assertControllerName('User\Controller\Account');
    }
}
