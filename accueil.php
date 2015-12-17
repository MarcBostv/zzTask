<!-- > Tout d'abord on vérifie que nous sommes bien connectés <-->
<?php
	require('fonctions.php');
	controleSession();
	include_once controleLang();
	
	if(isset($_GET['action']) && $_GET['action'] == 'deco')
	{
		deconnexion();
		return;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<!-- > Titre de la page, apparait sur l'onglet de la page <-->
		<title> <?php echo $lang['PAGE_TITLE']; ?></title>
		<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
		<!-- > Texte d'explication <-->	
		<h3><a href="accueil.php"><?php echo $lang['HEADER_TITLE']; ?></a></h3>
	</head>
	<body>	
		<a href="nouvelleTache.php"><?php echo $lang['CREATE_TASK']; ?></a>
		<a href="accueil.php?action=deco"><?php echo $lang['LOGOUT'];?></a>
	</body>
</html>			


