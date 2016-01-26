<?php

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    
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
			if(isset($_COOKIE['lang'])){
				$_SESSION['lang']=$_COOKIE['lang'];
			}else{
				$_SESSION['lang']='';
			}
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
		if ( ($fp = fopen($nomFichier, "r+"))!=true ) {
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
				$pass=$_POST['id'].$_POST['mdp'];
		        $mdp=hash('sha512', $pass);
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
			header("Location:accueil.php?action=deco");
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
		       $nmTsk=$_POST['nomTask'];
		       $dbt=$_POST['debut'];
		       $f=$_POST['fin'];
		       $desc=$_POST['description'];
		       
		       $nomTask=str_replace("::;;::","_",$nmTsk);
		       $description=str_replace("::;;::","_",$desc);
		       $pattern="[^0-9]";
		       $fin=preg_replace($pattern," / / ",$f);
		       $debut=preg_replace($pattern," / / ",$dbt);
		       list($day, $month, $year) = split('[/.-]', $debut);
		       list($dayf, $monthf, $yearf) = split('[/.-]', $fin);
		       
		       $debutok=checkdate($month, $day, $year);
		       $finok=checkdate($monthf, $dayf, $yearf);
		       
		       if(!$debutok || !$finok)
					echo("Erreur dans la saisie des dates");
					else {
					if(!$nomTask)
						echo("Erreur, saisissez un nom de tache");
						else {
							if($year>$yearf)
								echo("Erreur, l'annee de fin est anterieure a l'annee de debut");
								else {
									if($year==$yearf && $month>$monthf)
										echo("Erreur, le mois de fin est anterieur au mois de debut");
										else {
											if($month==$monthf && $day>$dayf)
												echo("Erreur, le jour de fin est anterieur au jour de debut");
											   else {
													if($year<date('Y',time()))			
														echo("Erreur, mauvaise annee saisie");
														else {
															if($year==date('Y',time()) && $month<date('m',time()))
																echo("Erreur, mauvais mois saisi");
																else {
																	if($month==date('m',time()) && $day<date('d',time()))
																		echo("Mauvais jour saisi");
																		else {
																			$idTask = rand(0, 1000000);
																			//on concatene
																			$champs=$idTask . "::;;::" . $id . "::;;::" . $nomTask . "::;;::" . $debut . "::;;::" . $fin . "::;;::" . $description . "\n";
																       
																			//on met en forme AAAAMMJJ
																			$fin=$yearf.$monthf.$dayf;
																			//on envoie dans le fichier
																			insertionFichier($fin, $champs);
																			header("Location:nouvelleTache.php");
																		}	
																}
														}
												}
										}
									}
								}
							}
		}
		else
		{
			echo("Erreur lors de la recuperration des variables de session");
		}	
	}	
	
	function insertionFichier($fin, $champs)
	{
		$lines=file("task.txt");
		$i=0;
		$tableau=array();
		foreach ($lines as $value){
			$task = explode("::;;::", $value, 6);
			$dateF=explode("/", $task[4],3);
			$finToCompare=$dateF[2].$dateF[1].$dateF[0];
			$tableau[$finToCompare] = $value;
			$i++;
		}
		$tableau[$fin] = $champs;
		ksort($tableau);
		$fp=ouvertureFichier("task.txt");
		
 		foreach ($tableau as $k => $v) {
				fwrite($fp, $v);
			}
	fclose($fp);
	}
				
	function afficherTask($task)
	{
  		$file=controleLang();
  		include $file;?>
		<div class="panel panel-primary">
			<a href="accueil.php?action=supr&value=<?php echo $task[0] ?>&user=<?php echo $task[1] ?>" class="btn btn-primary pull-right"><?php echo $lang['SUPR'];?></a>
			<div class="panel-heading"><?php echo $task[2]?></div>
			<div class="panel-body">
				<p>					
					<?php
						if(strcmp($_SESSION['id'],"david") == 0){
							?><b><?php echo $lang['T_USER']; ?> :</b> <?php echo $task[1];
						}
					?>
				</p>
				<p><b><?php echo $lang['T_FROM']; ?> </b> <?php echo $task[3] ?><b><?php echo $lang['T_TO']; ?></b><?php echo $task[4] ?></p>
				<p><b><?php echo $lang['T_CONTENT']; ?> : </b><?php echo $task[5] ?></p>
			</div>
		</div><?php	
	}
		
	function taskPassees()
	{
		$auj=getTime();
		$dateAuj=explode("/", $auj,3);
		$fp=ouvertureFichier("task.txt");
		$ligne=fgets($fp);
		while(!feof($fp)){
			$task = explode("::;;::", $ligne, 6);
			$user = $task[1];
			$dateF=explode("/", $task[4],3);
			
			if((strcmp($_SESSION['id'], "david") == 0) || (strcmp($user, $_SESSION['id']) == 0))
			{
				if(($dateAuj[2]>=$dateF[2])){
					if( ($dateAuj[2]>$dateF[2]) || (($dateAuj[2]==$dateF[2])&&(($dateAuj[1]>=$dateF[1])))){
						if(($dateAuj[2]>$dateF[2]) || ($dateAuj[1]>$dateF[1]) || (($dateAuj[1]==$dateF[1])&&(($dateAuj[0]>$dateF[0])))){
							afficherTask($task);
						}
					}
				}
			}
			$ligne=fgets($fp);
		}
		fclose($fp);
	}
	
	function taskPresentes()
	{
		$auj=getTime();
		$dateAuj=explode("/", $auj,3);
		$fp=ouvertureFichier("task.txt");
		$ligne=fgets($fp);
		while(!feof($fp)){
			$task = explode("::;;::", $ligne, 6);
			$dateF=explode("/", $task[4],3);
			$dateD=explode("/", $task[3],3);
			$user = $task[1];
			
			if((strcmp($_SESSION['id'], "david") == 0) || (strcmp($user, $_SESSION['id']) == 0))
			{
				if( ($dateAuj[2]<=$dateF[2])  &&  ($dateAuj[2]>=$dateD[2])){
					if( (($dateAuj[2]<$dateF[2]) || (($dateAuj[2]==$dateF[2])&&(($dateAuj[1]<=$dateF[1]))))  &&  (($dateAuj[2]>$dateD[2]) || (($dateAuj[2]==$dateD[2])&&(($dateAuj[1]>=$dateD[1]))))){
						if( (($dateAuj[2]<$dateF[2]) || ($dateAuj[1]<$dateF[1]) || (($dateAuj[1]==$dateF[1])&&(($dateAuj[0]<=$dateF[0]))))
							&& (($dateAuj[2]>$dateD[2]) || ($dateAuj[1]>$dateD[1]) || (($dateAuj[1]==$dateD[1])&&(($dateAuj[0]>=$dateD[0]))))){
							afficherTask($task);
						}
					}
				}
			}
			$ligne=fgets($fp);
		}
		fclose($fp);
	}
	
	function taskFutures()
	{
		$auj=getTime();
		$dateAuj=explode("/", $auj,3);
		$fp=ouvertureFichier("task.txt");
		$ligne=fgets($fp);
		while(!feof($fp)){
			$task = explode("::;;::", $ligne, 6);
			$dateD=explode("/", $task[3],3);
			$user = $task[1];
			
			if((strcmp($_SESSION['id'], "david") == 0) || (strcmp($user, $_SESSION['id']) == 0))
			{
				if(($dateAuj[2]<=$dateD[2])){
					if( ($dateAuj[2]<$dateD[2]) || (($dateAuj[2]==$dateD[2])&&(($dateAuj[1]<=$dateD[1])))){
						if(($dateAuj[2]<$dateD[2]) || ($dateAuj[1]<$dateD[1]) || (($dateAuj[1]==$dateD[1])&&(($dateAuj[0]<$dateD[0])))){
							afficherTask($task);
						}
					}
				}
			}
			$ligne=fgets($fp);
		}
		fclose($fp);
	}
	
	function suppressionTask($id)
	{		
		$lines=file("task.txt");
		$tableau=array();
		foreach ($lines as $value){
			$task = explode("::;;::", $value, 6);
			$tableau[$task[0]] = $value;
		}
		$fp=fopen("task.txt", "w+");
		
 		foreach ($tableau as $task => $ligne) {
			if($task != $id)
				fwrite($fp, $ligne);
		}
		fclose($fp);
	
		header("Location:accueil.php");
	}
	
	
	/*
	 * fonction raffraichir
	 * supprime les taches sur lesquelles l'utilisateur à les droits et qui ont plus d'un mois
	 * 
	 * pour l'instant ne marche pas
	*/
	function suppressionTaskMois()
	{
		$lines=file("task.txt");
		$tableau=array();
		foreach ($lines as $value){
			$task = explode("::;;::", $value, 6);
			$dateF=explode("/", $task[4],3);
			$dateTask=$dateF[2].$dateF[1].$dateF[0];
			$tableau[$dateTask] = $value;
		}
		date_default_timezone_set('Europe/Paris');
		$date = date('Ymd', strtotime('-1 month'));
		
		$fp=fopen("task.txt", "w+");
		
 		foreach ($tableau as $dateTask => $ligne) {
			if (((strcmp($_SESSION['id'], "david") == 0) && ($dateTask > $date)) || (strcmp($_SESSION['id'], $task[1]) !=0) || ( (strcmp($_SESSION['id'], $task[1]) ==0) && ($dateTask > $date))){
					fwrite($fp, $ligne);
			}			
		}
	fclose($fp);
	
	header("Location:accueil.php");
	}
	
	function inscription()
	{
		if(strcmp($_SESSION['id'], "david") != 0){
			header("Location:accueil.php");
		}
		
		if (isset($_POST['newMDP']) AND isset($_POST['newMDPbis']) AND isset($_POST['newID']))
		{
			// Si oui on récupère ces variables, en hachant le mot de passe
			if(strcmp($_POST['newMDP'], $_POST['newMDPbis'])==0){
				$pass=$_POST['newID'].$_POST['newMDP'];
			    $mdp=hash('sha512', $pass);
			    $id=$_POST['newID'];
			    $inser=$id . " " . $mdp . "\n";			    
			    $fp=fopen("log.txt", "a+");
			    
			    $stop=0;
			    $lines=file("log.txt");
			    foreach ($lines as $value){
					$usr = explode(" ", $value, 2);
					if(strcmp($usr[0], $id) == 0){
						$stop=1;
					}
				}
				if($stop==0){
					fwrite($fp, $inser);
					echo "Gazier crée";
				}else{
					echo "Ce nom d'utilisateur est déjà enregistré";
				}
			}else{
				echo "Mots de passes differents";
			}
		}
		else
		{
			echo "Veuillez renseigner les champs";
		}
	}
?>
