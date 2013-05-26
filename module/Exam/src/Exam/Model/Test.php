<?php
namespace Exam\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature;

class Test extends AbstractTableGateway
{
	public function __construct()
	{
		$this->table = 'tests';
		$this->featureSet = new Feature\FeatureSet();
		$this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
		$this->initialize();
	}
}