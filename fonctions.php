<?php

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    
	function controleSession($connect) //ne pas tester
	{
		if($connect!=1)
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
	
	function connexion($identifiant, $motdepasse)
	{
		$var=false;
		// On initialise connect à 0
		$_SESSION['connect']=0; 
		
		// On vérifie que l'utilisateur a bien tapé le login et le mot de passe
		if (isset($motdepasse) AND isset($identifiant))
		{
				// Si oui on récupère ces variables, en hachant le mot de passe
				$pass=$identifiant.$motdepasse;
		        $mdp=hash('sha512', $pass);
		        $id=$identifiant;
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
					$var=true;
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
		
		return $var;
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
		
	function creationTask($oui, $nmTsk, $dbt, $f, $desc)
	{			
		// On vérifie que l'utilisateur a bien saisi tous les champs
		if (isset($nmTsk) && isset($dbt) && isset($f) && isset($desc))
		{
			   // Si oui on récupère ces variables
			   $id=$_SESSION['id'];
			   		       
		       $nomTask=str_replace("::;;::","_",$nmTsk);		       
		       $desc1=str_replace("::;;::","_",$desc);
		       $description=str_replace("\n","",$desc1);
		       
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
													if($oui[0]<0){
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
													}else{
														
														$champs=$oui[0] . "::;;::" . $oui[1] . "::;;::" . $nomTask . "::;;::" . $debut . "::;;::" . $fin . "::;;::" . $description . "\n";
														//on met en forme AAAAMMJJ
														$fin=$yearf.$monthf.$dayf;
														//on envoie dans le fichier
														insertionFichier($fin, $champs);
														header('Location:modifierTache.php?action=modif&value='.$oui[0]);
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
				
	function afficherTask($task, $id)
	{
  		$file=controleLang();
  		include $file;?>
		<div class="panel panel-primary">
			<a href="accueil.php?action=supr&value=<?php echo $task[0] ?>&user=<?php echo $task[1] ?>" class="btn btn-primary pull-right"><?php echo $lang['SUPR'];?></a>
		<!-- Debut pop-up -->
			<a class="btn btn-large btn-info pull-right" onclick="popup('modifierTache.php?action=modif&value=<?php echo $task[0] ?>')"><?php echo $lang['MODIF'];?></a>
			
			<script LANGUAGE="JavaScript"> 
				function popup(tmp)
				{ 
					window.open(tmp,'popup','width=600,height=300,toolbar=false,scrollbars=false'); 
				} 
			</script>
		<!-- Fin pop-up -->
			<div class="panel-heading"><?php echo $task[2]?></div>
			<div class="panel-body">
				<p>					
					<?php
						if(strcmp($id,"david") == 0){
							?><b><?php echo $lang['T_USER']; ?> :</b> <?php echo $task[1];
						}
					?>
				</p>
				<p><b><?php echo $lang['T_FROM']; ?> </b> <?php echo $task[3] ?><b><?php echo $lang['T_TO']; ?></b><?php echo $task[4] ?></p>
				<p><b><?php echo $lang['T_CONTENT']; ?> : </b><?php echo $task[5] ?></p>
			</div>
		</div><?php	
	}
		
	function taskPassees($id)
	{
		$var=false;
		$auj=getTime();
		$dateAuj=explode("/", $auj,3);
		$fp=ouvertureFichier("task.txt");
		$ligne=fgets($fp);
		while(!feof($fp)){
			$task = explode("::;;::", $ligne, 6);
			$user = $task[1];
			$dateF=explode("/", $task[4],3);
			
			if((strcmp($id, "david") == 0) || (strcmp($user, $id) == 0))
			{
				if(($dateAuj[2]>=$dateF[2])){
					if( ($dateAuj[2]>$dateF[2]) || (($dateAuj[2]==$dateF[2])&&(($dateAuj[1]>=$dateF[1])))){
						if(($dateAuj[2]>$dateF[2]) || ($dateAuj[1]>$dateF[1]) || (($dateAuj[1]==$dateF[1])&&(($dateAuj[0]>$dateF[0])))){
							$var=true;
							afficherTask($task, $id);
						}
					}
				}
			}
			$ligne=fgets($fp);
		}
		fclose($fp);
		return $var;
	}
	
	function taskPresentes($id)
	{
		$var=false;
		$auj=getTime();
		$dateAuj=explode("/", $auj,3);
		$fp=ouvertureFichier("task.txt");
		$ligne=fgets($fp);
		while(!feof($fp)){
			$task = explode("::;;::", $ligne, 6);
			$dateF=explode("/", $task[4],3);
			$dateD=explode("/", $task[3],3);
			$user = $task[1];
			
			if((strcmp($id, "david") == 0) || (strcmp($user, $id) == 0))
			{
				if( ($dateAuj[2]<=$dateF[2])  &&  ($dateAuj[2]>=$dateD[2])){
					if( (($dateAuj[2]<$dateF[2]) || (($dateAuj[2]==$dateF[2])&&(($dateAuj[1]<=$dateF[1]))))  &&  (($dateAuj[2]>$dateD[2]) || (($dateAuj[2]==$dateD[2])&&(($dateAuj[1]>=$dateD[1]))))){
						if( (($dateAuj[2]<$dateF[2]) || ($dateAuj[1]<$dateF[1]) || (($dateAuj[1]==$dateF[1])&&(($dateAuj[0]<=$dateF[0]))))
							&& (($dateAuj[2]>$dateD[2]) || ($dateAuj[1]>$dateD[1]) || (($dateAuj[1]==$dateD[1])&&(($dateAuj[0]>=$dateD[0]))))){
							afficherTask($task, $id);
							$var=true;
						}
					}
				}
			}
			$ligne=fgets($fp);
		}
		fclose($fp);
		return $var;
	}
	
	function taskFutures($id)
	{
		$var=false;
		$auj=getTime();
		$dateAuj=explode("/", $auj,3);
		$fp=ouvertureFichier("task.txt");
		$ligne=fgets($fp);
		while(!feof($fp)){
			$task = explode("::;;::", $ligne, 6);
			$dateD=explode("/", $task[3],3);
			$user = $task[1];
			
			if((strcmp($id, "david") == 0) || (strcmp($user, $id) == 0))
			{
				if(($dateAuj[2]<=$dateD[2])){
					if( ($dateAuj[2]<$dateD[2]) || (($dateAuj[2]==$dateD[2])&&(($dateAuj[1]<=$dateD[1])))){
						if(($dateAuj[2]<$dateD[2]) || ($dateAuj[1]<$dateD[1]) || (($dateAuj[1]==$dateD[1])&&(($dateAuj[0]<$dateD[0])))){
							afficherTask($task, $id);;
							$var=true;
						}
					}
				}
			}
			$ligne=fgets($fp);
		}
		fclose($fp);
		return $var;
	}
	
	function suppressionTask($id, $oui)
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
	
		if($oui==1){
			header("Location:accueil.php");
		}
	}
		
	function inscription($id, $nid, $nmdp, $nmdpbis)
	{
		$var=false;
		if(strcmp($id, "david") != 0){
			header("Location:accueil.php");
		}
		
		if (isset($nmdp) AND isset($nmdpbis) AND isset($nid))
		{
			// Si oui on récupère ces variables, en hachant le mot de passe
			if(strcmp($nmdp, $nmdpbis)==0){
				$pass=$id.$nmdp;
			    $mdp=hash('sha512', $pass);
			    $id=$id;
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
					$var=true;
				}else{
					echo "Ce nom d'utilisateur est déjà enregistré";
					$var=1;
				}
			}else{
				echo "Mots de passes differents";
			}
		}
		else
		{
			echo "Veuillez renseigner les champs";
		}
		return $var;
	}
	
	function modifierTask($id)
	{
		$i=-1;
		$lines=file("task.txt");
		$cp=count($lines);	
		do
		{
			$cp--;
			$i++;
			$task = explode("::;;::", $lines[$i], 6);	
		}while($cp >= 0 && (($task[0] != $id)));
				
		if((strcmp($_SESSION['id'], "david") != 0) && (strcmp($_SESSION['id'], $task[1]) != 0))
		{
			echo ("modification non autorisée");
		}else{
			return $task;		
		}
	}

?>
