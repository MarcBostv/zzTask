<?php

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
     
    /*This function is used to check the current session
     * 
     * */
     
	function controleSession()
	{
		if($_SESSION['connect']!=1)
		{
			// If we are not connected, we go back to the homepage
			header("Location:index.php");
			exit;
		}
	}
	
	/*Function used to check the language
	 * 
	 * */
	
	function controleLang()
	{
		if(!isset($_SESSION['lang']))	//If we are not connected
		{
			if(isset($_COOKIE['lang'])){	//We check the cookie to get the language
				$_SESSION['lang']=$_COOKIE['lang'];
			}else{
				$_SESSION['lang']='';	//Else we use the default language
			}
		}
		
		$lang=$_SESSION['lang'];
		
		switch ($lang) {	//These are all the languages used. French is the default
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
	
	/*Function to get the current time. We will use this to check the dates entered by the user
	 * 
	 * */
	
	function getTime()
	{
		date_default_timezone_set('Europe/Paris');
		$date = date('d/m/Y', time()); //We use the format Day(DD)/Month(MM)/Year(YYYY)
		return $date;
	}
	
	/*Function used to open a file
	 * 
	 * */
	
	function ouvertureFichier($nomFichier)
	{
		if ( ($fp = fopen($nomFichier, "r+"))!=true ) {
			echo "Erreur ouverture fichier !";
			$fp=false;
		}
		return $fp; //We check if the openning worked correctly
	}
	
	/*Function used to connect. It takes the user's ID and his password in parameters 
	 * 
	 * */
	
	function connexion($identifiant, $motdepasse)
	{
		$var=false;
		$_SESSION['connect']=0; 
		
		// We check that the user entered correctly his ID and his password
		if (isset($motdepasse) AND isset($identifiant))
		{
				// If yes, we recover all the informations
				$pass=$identifiant.$motdepasse;
		        $mdp=hash('sha512', $pass);
		        $id=$identifiant;
		}
		else
		{
		        $mdp="";
		        $id="";
		}
		
			// We create a variable coposed of the user's ID and the ciphed password, these datas are stored in log.txt
			$test=$id . " " . $mdp . "\n";
		
		if(!$monfichier = fopen("fichiers/log.txt", "r"))
		{
			echo("erreur ouverture fichier");
		}
		else
		{	
			// We check the file line per line
			$ligne = fgets($monfichier);
			while(!feof($monfichier) and $_SESSION['connect'] == 0)
			{
				// If the line is equal to "login passwordCiphed"
				if ($test==$ligne)
				{
					$var=true;
					// We set connect at "1" and we store the id
					$_SESSION['connect']=1;
					$_SESSION['id']=$id;
				}
				$ligne = fgets($monfichier);
			}
			fclose($monfichier);
		}
		
		return $var;
	}
	
	/*Function used to disconnect from the website
	 * 
	 * */
		
	function deconnexion()
	{		
		session_unset();
		session_destroy();
		header("Location:index.php");
	}
	
	/*This function is used to create new tasks. It takes in parameters the name of the task, the date of start, the date of stop, 
	 * the description and a variable named "oui" which is used to change the treatment is this function is called from the form
	 * Create Task and the form Modify Task.
	 * 
	 * */
	
	function creationTask($oui, $nmTsk, $dbt, $f, $desc)
	{			
		// We check taht the used entered the right parameters
		if (isset($nmTsk) && isset($dbt) && isset($f) && isset($desc))
		{
			   // If yes, we recover those variables
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
		       
		       /*All these tests are here the be sure the user will enter correct start and stop dates
		       A user won't be able to enter de date which is older that the current date or a start date
		       which is older than the stop date*/
		       
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
																				//We concatenate
																				$champs=$idTask . "::;;::" . $id . "::;;::" . $nomTask . "::;;::" . $debut . "::;;::" . $fin . "::;;::" . $description . "\n";
																	       
																				//We put it in the right format
																				$fin=$yearf.$monthf.$dayf;
																				//We write it in the file
																				insertionFichier($fin, $champs, "task.txt");
																				header("Location:nouvelleTache.php");
																			}	
																	}
															}
													}else{
														
														$champs=$oui[0] . "::;;::" . $oui[1] . "::;;::" . $nomTask . "::;;::" . $debut . "::;;::" . $fin . "::;;::" . $description . "\n";
														$fin=$yearf.$monthf.$dayf;
														insertionFichier($fin, $champs, "task.txt");
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
	
	/*Function used to insert a new task in the file. It takes in parameters the stop date and the line
	 * 
	 * */
	
	function insertionFichier($fin, $champs, $fic)
	{
		$ret=false;
		if($fin>=0){
			$lines=file("fichiers/".$fic);
			$i=0;
			$tableau=array();
			foreach ($lines as $value){
				$task = explode("::;;::", $value, 6);
				$dateF=explode("/", $task[4],3);
				$finToCompare=$dateF[2].$dateF[1].$dateF[0];
				$tableau[$finToCompare] = $value;
				$i++;
			}	//We create a board with containing all the tasks written in the file. The we sort the board and we insert the new task at the correct place
			$tableau[$fin] = $champs;
			ksort($tableau);
			if($fp=ouvertureFichier("fichiers/".$fic))
			{
		 		foreach ($tableau as $k => $v) {
					fwrite($fp, $v);
				}
			fclose($fp);
			$ret=true;
			}
		}
		return $ret;
	}
	
	/*Function used to print the tasks on the dashboard. It takes in parameteres the task and the user's ID
	 * 
	 * */
				
	function afficherTask($task, $id)
	{
  		$file=controleLang();
  		include $file;?>
		<div class="panel panel-primary">
			<a href="accueil.php?action=supr&value=<?php echo $task[0] ?>&user=<?php echo $task[1] ?>" class="btn btn-primary pull-right"><?php echo $lang['SUPR'];?></a>
		<!-- Start pop-up -->
			<a class="btn btn-large btn-info pull-right" onclick="popup('modifierTache.php?action=modif&value=<?php echo $task[0] ?>')"><?php echo $lang['MODIF'];?></a>
			
			<script LANGUAGE="JavaScript"> 
				function popup(tmp)
				{ 
					window.open(tmp,'popup','width=600,height=300,toolbar=false,scrollbars=false'); 
				} 
			</script>
		<!-- Stop pop-up -->
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
	
	/*This function is used to prints past tasks on the dashboard. It takes the user's ID in parameters to check if the user has the rights
	 * see those tasks. Only the admin and the task owner can see a specific task. It the same for current and futures tasks.
	 * 
	 * */
		
	function taskPassees()
	{
		$id=$_SESSION['id'];
		$var=false;
		$auj=getTime();
		$dateAuj=explode("/", $auj,3);
		$fp=ouvertureFichier("fichiers/task.txt");
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
	
	/*This function is used to prints current tasks on the dashboard.
	 * 
	 * */
	
	function taskPresentes()
	{
		$id=$_SESSION['id'];
		$var=false;
		$auj=getTime();
		$dateAuj=explode("/", $auj,3);
		$fp=ouvertureFichier("fichiers/task.txt");
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
	
	/*This function is used to prints future tasks on the dashboard
	 * 
	 * */
	
	function taskFutures()
	{
		$id=$_SESSION['id'];
		$var=false;
		$auj=getTime();
		$dateAuj=explode("/", $auj,3);
		$fp=ouvertureFichier("fichiers/task.txt");
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
	
	/*Function used to delete a task. It takes in parameter the user's ID, because a task can me deleted only by the admin and the
	 * owner or the task, and "oui" which is used to know if this function is called from the Dashboard or the Modification page
	 * 
	 * */
	
	function suppressionTask($id, $oui, $fichier)
	{	
		$ret=false;
		if($id>=0)
		{
			$lines=file("fichiers/".$fichier);
			$tableau=array();
			foreach ($lines as $value){
				$task = explode("::;;::", $value, 6);
				$tableau[$task[0]] = $value;
			}
			if($fp=fopen("fichiers/".$fichier, "w+"))
			{
		 		foreach ($tableau as $task => $ligne) {
					if($task != $id)
						fwrite($fp, $ligne);
				}
				fclose($fp);
				$ret=true;
			}
			if($oui==1){
				header("Location:accueil.php");
			}
		}
		return $ret;
	}
	
	/*Function used to create a new user. It takes in parameters the newx user's ID, the new password and a corfimation
	 * of the new password wich is suposed to be the same string
	 * 
	 * */
	
	function inscription($id, $nmdp, $nmdpbis)
	{
		$var=false;
		if(strcmp($_SESSION['id'], "david") != 0){
			header("Location:accueil.php");
		}
		
		if (isset($nmdp) AND isset($nmdpbis) AND isset($id))
		{
			// If it's ok, we recover the variables and we cipher the password
			if(strcmp($nmdp, $nmdpbis)==0){
				$pass=$id.$nmdp;
			    $mdp=hash('sha512', $pass);
			    $inser=$id . " " . $mdp . "\n";			    
			    $fp=fopen("fichiers/log.txt", "a+");
			    
			    $stop=0;
			    $lines=file("fichiers/log.txt");
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
	
	/*Fonction called when a user want to modify a task. It takes the user's ID in parameters.
	 * If the user is not allowed to modify the task, it will reroute him to the homepage.
	 * 
	 * */
	
	function modifierTask($id)
	{
		$i=-1;
		$lines=file("fichiers/task.txt");
		$cp=count($lines);	
		do
		{
			$cp--;
			$i++;
			$task = explode("::;;::", $lines[$i], 6);	
		}while($cp >= 0 && (($task[0] != $id)));
				
		if((strcmp($_SESSION['id'], "david") != 0) && (strcmp($_SESSION['id'], $task[1]) != 0))
		{
			header("Location:accueil.php");
		}else{
			return $task;		
		}
	}
	
	/*Function used to change of password. It takes in parameters the user's name, the old mdp, the new mdp and a confirmation
	 * of the new mdp which is suposed to be the same. It will change the mdp only if the old one is correct
	 * 
	 * */

	function changeMdp($user, $omdp, $nmdp, $nmdp2)
	{
		$var=false;
		if(strcmp($_SESSION['id'], "david") != 0)
		{
			header("Location:accueil.php");
		}
			
		if (isset($user) AND isset($omdp) AND isset($nmdp) AND isset($nmdp2))
		{	
			$i=-1;
			$lines=file("fichiers/log.txt");
			$cp=count($lines);	
			do
			{
				$cp--;
				$i++;
				$task = explode(" ", $lines[$i], 2);	
			}while($cp >= 0 && (($task[0] != $user)));
			
			if(strcmp($task[0], $user) != 0)
				echo ("l'utilisateur n'existe pas");
			else
			{
				$comp=$user.$omdp;
				$compar=hash('sha512', $comp);
				if(strcmp($task[1], $compar) == 0)
					echo "mauvais ancien mot de passe";
				else
				{
					// If it's ok, we recover the variables and we cipher the password
					if(strcmp($nmdp, $nmdp2)==0){
						$pass=$user.$nmdp;
					    $mdp=hash('sha512', $pass);
					    $inser=$user . " " . $mdp . "\n";			    
					    $fp=ouvertureFichier("fichiers/log.txt");
					    
					    $stop=0;
					    $lines=file("fichiers/log.txt");
					    foreach ($lines as $value){
							$usr = explode(" ", $value, 2);
							if($user != $usr[0])
								fwrite($fp, $value);
						}
						fwrite($fp,	$inser);					
					}else{
						echo "Nouveaux mots de passes differents";
					}
				}
			}
		}else{
			echo "Veuillez renseigner les champs";
		}
		return $var;
	}
	
?>
