<!-- > Tout d'abord on vérifie que nous sommes bien connectés <-->
<?php
	require('fonctions.php'); //We use the file function.php thus use the components inside
	controleSession();
	
	//We call the disconnection function only when the recieve the GET parameter "deco"
	if(isset($_GET['action']) && $_GET['action'] == 'deco')
	{
		setcookie('id', $_SESSION['id']); //Before deconnecting, we recover the cookie for the next connection
		deconnexion();
		return;
	}
	//When someone wants to change the language, we change it and we save it in a cookie for the next connection
	if(isset($_GET['lang']))
	{
		$_SESSION['lang']=$_GET['lang'];
		setcookie('lang', $_SESSION['lang']);
	}
	
	//When someone wants to delete a taks, we check if we recieve the identifier "value" of the task
  	if(isset($_GET['action']) && $_GET['action'] == 'supr' && isset($_GET['value']))
	{	
		//Then we check if the user is authorized to delete this task
		if((strcmp($_SESSION['id'],"david") == 0) || (strcmp($_SESSION['id'], $_GET['user']) == 0))
<<<<<<< HEAD
			suppressionTask($_GET['value'],1); 	//If all the test are OK, we call the suppression function
=======
			suppressionTask($_GET['value'],1, "task.txt");
>>>>>>> 1ed20c694e883827c98e09c8fbd9de05d5f41361
		else
			echo("Vous n'etes pas autorise a supprimer cette tache (petit coquin)"); //If not, we print an error message
		return;
	}

	//We call controleLang to print the dashboard in the correct language
	include_once controleLang();
	
	$selected="accueil";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<!-- > Head of the page <-->
		<title> <?php echo $lang['PAGE_TITLE']; ?></title>
		<link rel="stylesheet" href="bootstrap.css">	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="bootstrap.js"></script>
    
		<?php include('header.php');?>
	
	</head>

	<body>
		<div class="row">
			<!-- left column -->
			<div class="col-md-4">
				<div class="thumbnail">
					<div class="caption">
						<div>
							<h3><?php echo $lang['T_PAST']; ?></h3>
						</div>
						
						<?php taskPassees();?>
						
					</div>
				</div>
			</div>

			<!-- center column -->
			<div class="col-md-4">
				<div class="thumbnail">
					<div class="caption">
						<div>
							<h3><?php echo $lang['T_PRES']; ?></h3>
						</div>
						
						<?php taskPresentes();?>

					</div>
				</div>
			</div>

			<!-- right column -->
			<div class="col-md-4">
				<div class="thumbnail">
					<div class="caption">
						<div>
							<h3><?php echo $lang['T_FUTURE']; ?></h3>
						</div>
						
						<?php taskFutures();?>
						
					</div>
				</div>
			</div>
		</div>
	</body>
</html>			
