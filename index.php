<?php
	require('fonctions.php');
	include_once controleLang();
	
	if(isset($_POST['id']) && isset($_POST['mdp']))
	{
		connexion();
		return;
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8" />
		<!-- > Titre de la page, apparait sur l'onglet de la page <-->
		<title> <?php echo $lang['PAGE_TITLE']; ?></title>
		
		<!-- insertion du css-->
		<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
			
	</head>
	<body>
		<!-- > Création d'un formulaire de connexion, on utilisera la methode post <-->
		<div class="container">
		<!-- > Texte d'explication <-->	
		<h3> <?php echo $lang['ID']; ?> </h3>	
			<form method="post" action="">
				<div class="form-group">
					<label for="id" class="col-sm-2 control-label"> <?php echo  $lang['ID_FIELD']; ?> </label>
					<div class="col-sm-10">
						<input type="email" class="form-control" id="id" name="id" placeholder="Email">
					</div>
				</div>
				<div class="form-group">
					<label for="mdp" class="col-sm-2 control-label"> <?php echo  $lang['PASSWORD_FIELD']; ?> </label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="mdp" name="mdp" placeholder="Password">
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


