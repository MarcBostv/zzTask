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
		<title><?php echo $lang['CREATING_TASK']; ?></title>
		<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
		<!-- > Texte d'explication <-->	
		<h3><a href="accueil.php"><?php echo $lang['HEADER_TITLE']; ?></a></h3>
		<a href="nouvelleTache.php?action=deco"><?php echo $lang['LOGOUT'];?></a>	

	</head>
	<body>
		<form method="post" action="creationTask.php">
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-5">
					<input type="text" name="nomTask" class="form-control" placeholder="<?php echo $lang['TEXT_INPUT'];?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-5">
					<input type="date" name="debut" placeholder=" <?php echo $lang['DATE_START'];?>" min=<?php getTime() ?> > 
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-5">
					<input type="date" name="fin" placeholder=" <?php echo $lang['DATE_STOP'];?>"min=>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-5">
					<textarea class="form-control" name="description" placeholder="<?php echo $lang['DESCRIPTION'];?> ..." rows="3"></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-5">
					<button type="submit" class="btn btn-primary" value="Creation"><?php echo $lang['CREATE'];?></button>
				</div>
			</div>
		</form>
	</body>
</html>			


