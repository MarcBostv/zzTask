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
		<section class="row">
			<div class="col-xs-4 col-sm-3 col-md-4" name="passe">
				<?php echo "bla"?>
			</div>
			<div class="col-xs-4 col-sm-3 col-md-4" name="present">
				<?php echo "bli"?>
			</div>
			<div class="col-xs-4 col-sm-3 col-md-4" name="futur">
				<?php echo "blu"?>
			</div>
		</section>	
	</body>
</html>			


