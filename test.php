<?php
require('fonctions.php');

class Login extends PHPUnit_Framework_TestCase
{
	public function setUp() {
		echo "I run before each test \n";
	}

	public function testControleLang(){
		echo "Init Test Lang \n";
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
		echo "Finished Test Lang \n";
	}
	
	public function testTime() {
		echo "Init Test Time \n";
		date_default_timezone_set('Europe/Paris');
		$date = date('d/m/Y', time());
		$res = getTime();
		$this->assertEquals($date, $res);
		echo "Finished Test Time \n";
	}
		
	public function testConnexion() {
		echo "Init Test Connection \n";
		$val=connexion("david", "david");
		$this->assertEquals($val, true);
		$val2=connexion("david", "mauvaismdp");
		$this->assertFalse($val2, true);
		echo "Finished Test Connection \n";
	}
		
	public function testInsertionFichier() {
		echo "Init Test Insert File \n";
		$val=insertionFichier(-52, "david", "task.txt");
		$this->assertEquals($val, false);
		$champs="42::;;::utilisateur::;;::Nom de la tache::;;::01/01/2000::;;::27/07/2222::;;::Sa description\n";
		$val2=insertionFichier("22220727", "$champs", "task.txt");
		$this->assertEquals($val2, true);
		suppressionTask(42, 0, "task.txt");
		echo "Finished Test Insert File \n";
	}	

	public function testSuppressionFichier() {
		echo "Init Test Delete File \n";
		$champs="51::;;::utilisateur::;;::Nom de la tache::;;::01/01/2000::;;::27/07/2333::;;::Sa description\n";
		insertionFichier(23330727, "$champs", "task.txt");
		$val=suppressionTask(-51, 0, "task.txt");
		$this->assertEquals($val, false);
		$val2=suppressionTask(51, 0, "task.txt");
		$this->assertEquals($val2, true);
		echo "Finished Test Delete File \n";
	}
	
	public function tearDown() {
		echo "I run after each test \n\n";
	}

}

?>
