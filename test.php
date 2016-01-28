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
		$this->assertEquals('langEn.php', $r1);
		$this->assertEquals('langFr.php', $r2);
		$this->assertEquals('langEn.php', $r3);
		$this->assertEquals('langEn.php', $r4);
	}
	
	public function testOuvertureFichier(){
		$r1=ouvertureFichier();
		$r2=ouvertureFichier("nexistePas");
		$r3=ouvertureFichier("task.txt");
//		$this->assertFalse
//		$this->assertEquals('langFr.php', $r2);
	}

	//test useless
	public function testTime() {
		date_default_timezone_set('Europe/Paris');
		$date = date('d/m/Y', time());
		$res = getTime();
		
		$this->assertEquals($date, $res);
	}
	
	public function tearDown() {
		echo "I run after each test \n";
	}
	
}

?>


