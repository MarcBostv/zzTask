<?php
require('fonctions.php');

class Login extends PHPUnit_Framework_TestCase
{
	public function setUp() {
		echo "I run before each test \n";
	}

	public function testControleLang(){
		$_SESSION['lang']='';
		$r1=controleLang();
		$_SESSION['lang']='fr';
		$r2=controleLang();
		$_SESSION['lang']='en';
		$r3=controleLang();
		$_SESSION['lang']='uebguvrbvjkrvbnlke';
		$r4=controleLang();
		$this->assertEquals('langFr.php', $r1);
		$this->assertEquals('langFr.php', $r2);
		$this->assertEquals('langEn.php', $r3);
		$this->assertEquals('langFr.php', $r4);
	}
	
	public function testTime() {
		date_default_timezone_set('Europe/Paris');
		$date = date('d/m/Y', time());
		$res = getTime();
		$this->assertEquals($date, $res);
	}
		
	public function testConnexion() {
		$val=connexion("david", "david");
		$this->assertEquals($val, true);
		$val2=connexion("david", "mauvaismdp");
		$this->assertFalse($val2, true);
	}
	
	public function testTaskPassees() {
		$val=taskPassees("david");
		$this->assertEquals($val, true);
		$val2=taskPassees("userbidon");
		$this->assertFalse($val2, true);
	}
	
	public function testTaskPresentes() {
		$val=taskPresentes("david");
		$this->assertEquals($val, true);
		$val2=taskPresentes("userbidon");
		$this->assertFalse($val2, true);
	}
	
	public function testTaskFutures() {
		$val=taskFutures("david");
		$this->assertEquals($val, true);
		$val2=taskPresentes("userbidon");
		$this->assertFalse($val2, true);
	}
	
	public function testInscription() {
		$val=inscription("david", "test1", "motdepasse", "motdepasse");
		$this->assertEquals($val, true);
		$val2=inscription("david", "test1", "motdepasse", "fautedefrappe");
		$this->assertFalse($val2, true);
	}
	
	public function tearDown() {
		echo "I run after each test \n";
	}
}

?>
