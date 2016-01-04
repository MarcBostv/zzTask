<?php
session_start();

	function controleSession() //ne pas tester
	{
		if($_SESSION['connect']!=1)
		{
			// Si ce n'est pas le cas, on retourne à l'index
			header("Location:index.php");
			exit;
		}
	}

	function controleLang()
	{
		if(!isset($_SESSION['lang']))
		{
			$_SESSION['lang']='';
		}
		
		$lang=$_SESSION['lang'];
		
		switch ($lang) {
			case 'en':
			$lang_file = 'langEn.php';
			break;
			 
			case 'fr':
			$lang_file = 'langFr.php';
			break;
			 
			default:
			$lang_file = 'langFr.php'; 
		}
		return $lang_file;
	}

	function getTime()
	{
		date_default_timezone_set('Europe/Paris');
		$date = date('d/m/Y', time());
		return $date;
	}
	
	function ouvertureFichier($nomFichier)
	{
		if ( ($fp = fopen($nomFichier, "a+"))!=true ) {
			echo "Erreur ouverture fichier !";
			$fp=false;
		}
		return $fp;
	}

	function connexion()
	{
				// On initialise connect à 0
		$_SESSION['connect']=0; 
		
		// On vérifie que l'utilisateur a bien tapé le login et le mot de passe
		if (isset($_POST['mdp']) AND isset($_POST['id']))
		{
				// Si oui on récupère ces variables, en hachant le mot de passe
		        $mdp=md5($_POST['mdp']);
		        $id=$_POST['id'];
		}
		else
		{
				// Sinon ces variables ne valent rien
		        $mdp="";
		        $id="";
		}
		
			// On crée une variable, composée du login et du mot de passe codé, format des données contenues dans log.txt
			$test=$id . " " . $mdp . "\n";
		
		// On essaie d'ouvrir le fichier log.txt
		if(!$monfichier = fopen("log.txt", "r"))
		{
			// Si on y arrive pas, message d'erreur
			echo("erreur ouverture fichier");
		}
		else
		{	
			// Sinon on lit le fichier ligne par ligne, tant qu'on est déconnecté et que le fichier n'est pas fini
			$ligne = fgets($monfichier);
			while(!feof($monfichier) and $_SESSION['connect'] == 0)
			{
				// Si une ligne est équivalente à notre variable "login passwordHaché"
				if ($test==$ligne)
				{
					// Alors connect passe à 1, et on stocke l'id de l'utilisateur
					$_SESSION['connect']=1;
					$_SESSION['id']=$id;
				}
				// Puis on lit la ligne suivante avant de reboucler
				$ligne = fgets($monfichier);
			}
			// On ferme le fichier log.txt
			fclose($monfichier);
		}
		
		// On teste si on est connecté
		if ($_SESSION['connect'] == 1)
		{
			// Si oui, on avance dans le site en se rendant sur accueil.php
			header("Location:accueil.php");
		}
		else
		{
			// Sinon on supprime les éventuelles données stockées dans la variable de session
			header("Location:deconnexion.php");
		}
	}
		
	function deconnexion()
	{
		// On supprime toutes les données contenues dedans
		session_unset();
		// On supprime notre variable de session
		session_destroy();
		// On retourne à l'index pour une éventuelle autre connexion
		header("Location:index.php");
	}
		
	function creationTask()
	{
		//ici on recupere les POST pour une tache ainsi que l'id user, et on la créée dans le .txt 
			
		// On vérifie que l'utilisateur a bien saisi tous les champs
		if (isset($_POST['nomTask']) && isset($_POST['debut']) && isset($_POST['fin']))
		{
				// Si oui on récupère ces variables
				$id=$_SESSION['id'];
		        $nomTask=$_POST['nomTask'];
		        $debut=$_POST['debut'];
		        $fin=$_POST['fin'];
		        $description=$_POST['description'];
		        
		        //on concatene
		        $champs=$id . " " . $nomTask . " " . $debut . " " . $fin . " " . $description;
		        
		        //on envoie dans le fichier
		        $fp=ouvertureFichier("task.txt");
		        fputs($fp, $champs);
		        fputs($fp, "\n"); 
		        fclose($fp);
		}
		else
		{
				// On ajoute une note en precisant qu'il faut tout remplir
				exit;
		}	
		header("Location:nouvelleTache.php");
	}	
		//function deleteTask
?>
