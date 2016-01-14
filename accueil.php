<!-- > Tout d'abord on vérifie que nous sommes bien connectés <-->
<?php
	require('fonctions.php');
	controleSession();
	
	if(isset($_GET['action']) && $_GET['action'] == 'deco')
	{
		deconnexion();
		return;
	}

  if(isset($_GET['lang']))
  {
    $_SESSION['lang']=$_GET['lang'];
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
							<div class="pull-right"><a href="#" class="btn btn-primary" role="button"><?php echo $lang['VOIR_TOUT']; ?></a></div>
							<h3><?php echo $lang['T_PAST']; ?></h3>
						</div>

						<?php afficherTask(); ?>
						<?php afficherTask(); ?>

					</div>
				</div>
			</div>

			<!-- colone du milieu-->
			<div class="col-md-4">
				<div class="thumbnail">
					<div class="caption">
						<div>
							<div class="pull-right"><a href="#" class="btn btn-primary" role="button"><?php echo $lang['VOIR_TOUT']; ?></a></a></div>
							<h3><?php echo $lang['T_PRES']; ?></h3>
						</div>

						<?php afficherTask(); ?>
						<?php afficherTask(); ?>
						<?php afficherTask(); ?>
						<?php afficherTask(); ?>						
						<?php afficherTask(); ?>
						
					</div>
				</div>
			</div>

			<!-- colone de droite-->
			<div class="col-md-4">
				<div class="thumbnail">
					<div class="caption">
						<div>
							<div class="pull-right"><a href="#" class="btn btn-primary" role="button"><?php echo $lang['VOIR_TOUT']; ?></a></div>
							<h3><?php echo $lang['T_FUTURE']; ?></h3>
						</div>

						<?php afficherTask(); ?>
						
					</div>
				</div>
			</div>
		</div>
	</body>
</html>			


