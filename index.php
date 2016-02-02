<?php
	require('fonctions.php');
	include_once controleLang();
	
	//We will call the connection function only if we have correct ID and password
	if(isset($_POST['id']) && isset($_POST['mdp']))
	{
		if(connexion($_POST['id'], $_POST['mdp']))
			header("Location:accueil.php");
		else
			header("Location:accueil.php?action=deco"); //If not, we call the function deconnection that will appear like a page refreshing
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8" />
		<!-- > Titre de la page, apparait sur l'onglet de la page <-->
		<title> <?php echo $lang['PAGE_TITLE']; ?></title>
		
		<!-- insertion du css-->
		<link rel="stylesheet" href="bootstrap.min.css">
			
	</head>
	<body>
		<!-- > Création d'un formulaire de connexion, on utilisera la methode post <-->
		<div class="container">
		<!-- > Texte d'explication <-->	
		<h3> <?php echo $lang['ID']; ?> </h3>	
			<form class="form-horizontal" method="post" action="index.php">
				<div class="form-group">
					<label class="control-label col-sm-2" for="id" class="col-sm-2 control-label"> <?php echo  $lang['ID_FIELD']; ?> </label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="id" name="id" value="<?php if(isset($_COOKIE['id'])) echo $_COOKIE['id']?>" placeholder="<?php echo $lang['ID_FIELD']?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="mdp" class="col-sm-2 control-label"> <?php echo  $lang['PASSWORD_FIELD']; ?> </label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="mdp" name="mdp" placeholder="<?php echo $lang['PASSWORD_FIELD']?>">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary" value="Connexion"> <?php echo  $lang['LOGIN']; ?> </button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>


