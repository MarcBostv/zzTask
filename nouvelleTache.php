<!-- > Tout d'abord on v�rifie que nous sommes bien connect�s <-->
<?php
	require('fonctions.php');
	controleSession();
	
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
	
	include_once controleLang();
  
	//We read all the parameters to call the function creationTask
	if(isset($_POST['nomTask']) && isset($_POST['debut']) && isset($_POST['fin']) && isset($_POST['description']))
	{
		//The first parameter is set to -1 to pass threw all the tests
		$task[0]=-1;
		creationTask($task, $_POST['nomTask'], $_POST['debut'], $_POST['fin'], $_POST['description']);
		
		return;
	}
	
	$selected="nouvelleTache";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<!-- > Titre de la page, apparait sur l'onglet de la page <-->
		<title><?php echo $lang['CREATING_TASK']; ?></title>
		<link rel="stylesheet" href="bootstrap.css">
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    	<script src="bootstrap.js"></script>

		<?php include('header.php');?>

	</head>
	<body>
		<form method="post" action="">
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
					<input type="date" name="fin" placeholder=" <?php echo $lang['DATE_STOP'];?>"min=<?php getTime() ?> >
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
