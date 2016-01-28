<!-- > Tout d'abord on vérifie que nous sommes bien connectés <-->
<?php
	require('fonctions.php');
	controleSession($_SESSION['connect']);
	
	if(isset($_GET['action']) && $_GET['action'] == 'deco')
	{
		setcookie('id', $_SESSION['id']);
		deconnexion();
		return;
	}
	if(isset($_GET['lang']))
	{
		$_SESSION['lang']=$_GET['lang'];
		setcookie('lang', $_SESSION['lang']);
	}
	
  	if(isset($_GET['action']) && $_GET['action'] == 'supr' && isset($_GET['value']))
	{
		if((strcmp($_SESSION['id'],"david") == 0) || (strcmp($_SESSION['id'], $_GET['user']) == 0))
			suppressionTask($_GET['value'],1);
		else
			echo("Vous n'etes pas autorise a supprimer cette tache (petit coquin)");
		return;
	}

	include_once controleLang();
	
	$selected="accueil";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<!-- > Titre de la page, apparait sur l'onglet de la page <-->
		<title> <?php echo $lang['PAGE_TITLE']; ?></title>
		<link rel="stylesheet" href="bootstrap.css">	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="bootstrap.js"></script>
    
		<?php include('header.php');?>
	
	</head>

	<body>
		<div class="row">
			<!-- colone de gauche-->
			<div class="col-md-4">
				<div class="thumbnail">
					<div class="caption">
						<div>
							<h3><?php echo $lang['T_PAST']; ?></h3>
						</div>
						
						<?php taskPassees($_SESSION['id']);?>
						
					</div>
				</div>
			</div>

			<!-- colone du milieu-->
			<div class="col-md-4">
				<div class="thumbnail">
					<div class="caption">
						<div>
							<h3><?php echo $lang['T_PRES']; ?></h3>
						</div>
						
						<?php taskPresentes($_SESSION['id']);?>

					</div>
				</div>
			</div>

			<!-- colone de droite-->
			<div class="col-md-4">
				<div class="thumbnail">
					<div class="caption">
						<div>
							<h3><?php echo $lang['T_FUTURE']; ?></h3>
						</div>
						
						<?php taskFutures($_SESSION['id']);?>
						
					</div>
				</div>
			</div>
		</div>
	</body>
</html>			
