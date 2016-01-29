<!-- > Tout d'abord on vérifie que nous sommes bien connectés <-->
<?php
	require('fonctions.php');
	controleSession();
	
	if(strcmp($_SESSION['id'], "david") != 0){
		header("Location:accueil.php");
	}
	
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
	
	if(isset($_POST['ID']) && isset($_POST['oldMDP']) && isset($_POST['newMDP']) && isset($_POST['newMDPbis']))
	{
		changeMdp($_POST['ID'],$_POST['oldMDP'],$_POST['newMDP'],$_POST['newMDPbis']);
	}
	
	include_once controleLang();
	
	$selected="nouveauMdp";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<!-- > Titre de la page, apparait sur l'onglet de la page <-->
		<title><?php echo $lang['CREATING_USER']; ?></title>
		<link rel="stylesheet" href="bootstrap.css">
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    	<script src="bootstrap.js"></script>

		<?php include('header.php');?>

	</head>
	<body>
		
			<form class="form-horizontal" method="post" action="">
				<div class="form-group">
					<label class="control-label col-sm-2" for="ID" class="col-sm-2 control-label"> <?php echo  $lang['USER']; ?> </label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="ID" name="ID" placeholder="<?php echo $lang['USER']?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="oldMDP" class="col-sm-2 control-label"> <?php echo  $lang['HPASSWORD_FIELD']; ?> </label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="oldMDP" name="oldMDP" placeholder="<?php echo $lang['HPASSWORD_FIELD']?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="newMDP" class="col-sm-2 control-label"> <?php echo  $lang['PASSWORD_FIELD']; ?> </label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="newMDP" name="newMDP" placeholder="<?php echo $lang['PASSWORD_FIELD']?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="newMDPbis" class="col-sm-2 control-label"> <?php echo  $lang['PASSWORD_FIELD_BIS']; ?> </label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="newMDPbis" name="newMDPbis" placeholder="<?php echo $lang['PASSWORD_FIELD_BIS']?>">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary" value="Creation"> <?php echo  $lang['VALID']; ?> </button>
					</div>
				</div>
			</form>
	</body>
</html>			


