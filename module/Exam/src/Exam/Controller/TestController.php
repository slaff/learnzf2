<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Exam for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Exam\Controller;

use Zend\Form\Factory;
use Zend\Mvc\Controller\AbstractActionController;

class TestController extends AbstractActionController
{
    public function indexAction()
    {
        return array();
    }

    public function takeAction()
    {
    	$id = $this->params('id');
        if(!$id) {
        	return $this->redirect()->toRoute('exam/list');
        }
        
        $factory = new Factory();
        $spec = include __DIR__.'/../../../config/form/form1.php';
        $form = $factory->create($spec);
        return array('form' => $form);
    }
}
