<!-- > Tout d'abord on vérifie que nous sommes bien connectés <-->
<?php
	require('fonctions.php');
	controleSession();
	include_once controleLang();
	
	if(!isset($_SESSION['id'])){
		header("Location:accueil.php");
	}

	if(isset($_GET['lang']))
	{
		$_SESSION['lang']=$_GET['lang'];
		setcookie('lang', $_SESSION['lang']);
	}
	
  	if(isset($_GET['action']) && $_GET['action'] == 'suprMois')
	{
		suppressionTaskMois();
		return;
	}
	
	if(isset($_POST['nomTask']) && isset($_POST['debut']) && isset($_POST['fin']) && isset($_POST['description']) && isset($_POST['value']))
	{
		suppressionTask($_GET['value'],0);
		creationTask($_GET['value']);
	}

	if(!(isset($_GET['action'])) || !(isset($_GET['value'])))
	{
		header("Location:accueil.php");
	}else{ 
		if(isset($_GET['action']) && $_GET['action'] == 'modif' && isset($_GET['value']))
		{
			$task=modifierTask($_GET['value']);
		}else{
			header("Location:accueil.php");
		}
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<!-- > Titre de la page, apparait sur l'onglet de la page <-->
		<title><?php echo $lang['UPDATING_TASK']; ?></title>
		<link rel="stylesheet" href="bootstrap.css">
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    	<script src="bootstrap.js"></script>

	</head>
	<body>
		<form method="post" action="">
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-5">
					<input type="text" name="nomTask" class="form-control" value="<?php echo $task[2];?>" placeholder="<?php echo $lang['TEXT_INPUT'];?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-5">
					<input type="date" name="debut" value="<?php echo $task[3];?>" placeholder=" <?php echo $lang['DATE_START'];?>" min=<?php getTime() ?> > 
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-5">
					<input type="date" name="fin" value="<?php echo $task[4];?>" placeholder=" <?php echo $lang['DATE_STOP'];?>"min=<?php getTime() ?> >
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-5">
					<textarea class="form-control" name="description" placeholder="<?php echo $lang['DESCRIPTION'];?> ..." rows="3"><?php echo $task[5];?></textarea>
				</div>
			</div>
			<input type="hidden" name="value" value"<?php echo $task;?>">
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-5">
					<button type="submit" class="btn btn-primary" value="Modification"><?php echo $lang['MODIF'];?></button>
				</div>
			</div>
		</form>
	</body>
</html>		
