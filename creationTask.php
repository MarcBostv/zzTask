<?php
	//Tout d'abord on vérifie que nous sommes bien connectés <-->
	require('fonctions.php');
	controleSession();
	
	//ici on recupere les POST pour une tache ainsi que l'id user, et on la créée dans le .txt 
		
	// On vérifie que l'utilisateur a bien saisi tous les champs
	if (isset($_POST['nomTask']) AND isset($_POST['debut']) AND isset($_POST['fin']))
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
	        fputs ($fp, $champs);
	        fclose($fp);
	        
	        //A TESTER !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	}
	else
	{
			// On ajoute une note en precisant qu'il faut tout remplir
			header("Location:nouvelleTache.php");
			exit;
	}

		
?>
