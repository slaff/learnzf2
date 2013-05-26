<?php
namespace Exam\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Form\Factory as FormFactory;

class TestManager implements ServiceLocatorAwareInterface 
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $services;
    
    /**
     * @var array
     */
    protected $cache;
    
    /**
     * Creates form for a  test
     * @param string $id
     * @return \Zend\Form\Form
     */
    public function createForm($id)
    {
    	$data = $this->get($id);
    	$spec = json_decode($data['definition'], true); 
    	if(!$spec) {
    		throw new \Exception('Invalid form specification');
    	}
    	
    	$factory = new FormFactory();
    	return $factory->create($spec);
    }

    public function get($id)
    {
        if (! isset($this->cache[$id])) {
            // The Test class is a table gateway class
            $model = new Test();
            $result = $model->select(array('id' => $id));
    	    $data = $result->current();
    	    $data['definition'] = $this->services->get('cipher')->decrypt($data['definition']);
    	    $this->cache[$id] = $data;
    	}
    	
    	return $this->cache[$id];
    }

    public function store($data) 
    {
        $model = new Test();
        $data['definition'] = $this->services->get('cipher')->encrypt($data['definition']);
        return $model->insert($data);
    }

    
    /**
     * Gets data about the factory default tests
     * 
     * @return array
     */
    public function getDefaultTests()
    {
    	$formFiles = glob(__DIR__.'/../../../config/form/form*.php');
    	$forms = array();
    	foreach($formFiles as $file) {
    	    $forms[] = include_once $file;
    	}
    	
    	return $forms;
    }
    
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator) 
	{	
		$this->services = $serviceLocator;
	}

	/* (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
	 */
	public function getServiceLocator() 
	{
		return $this->services;
	}
 }
