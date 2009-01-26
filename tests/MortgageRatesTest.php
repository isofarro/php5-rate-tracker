<?php
require_once 'PHPUnit/Framework.php';
require_once '../MortgageRates.php';

class MortgageRatesTest extends PHPUnit_Framework_TestCase {
	public function testInit() {
		$rates = new MortgageRates();
		
		$this->assertNotNull($rates);
	}

}



?>