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
	
	public function testInsertionFichier() {
		$val=insertionFichier(-52, "david", "test.txt");
		$this->assertEquals($val, false);
	}	

	public function testSuppression() {
		$val=suppressionTask(-52, 0, "test.txt");
		$this->assertEquals($val, false);
	}
	
	
	public function tearDown() {
		echo "I run after each test \n";
	}
}

?>
