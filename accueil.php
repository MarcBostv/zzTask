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
			<div class="col-md-4">
				<div class="thumbnail">
					<div class="caption">
						<div>
							<div class="pull-right"><a href="#" class="btn btn-primary" role="button"><?php echo $lang['VOIR_TOUT']; ?></a></div>
							<h3><?php echo $lang['T_PAST']; ?></h3>
						</div>
						<div class="panel panel-primary">
							<div class="panel-heading">La tâche</div>
							<div class="panel-body">
								<p>
								<?php
									if(strcmp($_SESSION['id'],"admin@isima.fr") == 0){
										?><b><?php echo $lang['T_USER']; ?> :</b> toto@isima.fr<?php
									}
								?>
								</p>
								<p><b><?php echo $lang['T_FROM']; ?> </b>01:01:2001 <b><?php echo $lang['T_TO']; ?></b> 02:02:2002 </p>
								<p><b><?php echo $lang['T_Content']; ?> : </b></p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="thumbnail">
					<div class="caption">
						<div>
							<div class="pull-right"><a href="#" class="btn btn-primary" role="button"><?php echo $lang['VOIR_TOUT']; ?></a></a></div>
							<h3><?php echo $lang['T_PRES']; ?></h3>
						</div>
						<div class="panel panel-primary">
							<div class="panel-heading">La tâche</div>
							<div class="panel-body">
								<p>
								<?php
									if(strcmp($_SESSION['id'],"toto@isima.fr") == 0){
										?><b><?php echo $lang['T_USER']; ?> :</b> toto@isima.fr<?php
									}
								?>
								</p>
								<p><b><?php echo $lang['T_FROM']; ?> </b>01:01:2001 <b><?php echo $lang['T_TO']; ?></b> 02:02:2002 </p>
								<p><b><?php echo $lang['T_Content']; ?> : </b></p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="thumbnail">
					<div class="caption">
						<div>
							<div class="pull-right"><a href="#" class="btn btn-primary" role="button"><?php echo $lang['VOIR_TOUT']; ?></a></div>
							<h3><?php echo $lang['T_FUTURE']; ?></h3>
						</div>
						<div class="panel panel-primary">
							<div class="panel-heading">La tâche</div>
							<div class="panel-body">
								<p><b><?php echo $lang['T_FROM']; ?> </b>01:01:2001 <b><?php echo $lang['T_TO']; ?></b> 02:02:2002 </p>
								<p><b><?php echo $lang['T_Content']; ?> : </b></p>
							</div>
						</div>
						
						<div class="panel panel-primary">
							<div class="panel-heading">La tâche</div>
							<div class="panel-body">
								<p><b><?php echo $lang['T_FROM']; ?> </b>01:01:2001 <b><?php echo $lang['T_TO']; ?></b> 02:02:2002 </p>
								<p><b><?php echo $lang['T_Content']; ?> : </b></p>
							</div>
						</div>
						
						<div class="panel panel-primary">
							<div class="panel-heading">La tâche</div>
							<div class="panel-body">
								<p><b><?php echo $lang['T_FROM']; ?> </b>01:01:2001 <b><?php echo $lang['T_TO']; ?></b> 02:02:2002 </p>
								<p><b><?php echo $lang['T_Content']; ?> : </b></p>
							</div>
						</div>
						
						<div class="panel panel-primary">
							<div class="panel-heading">La tâche</div>
							<div class="panel-body">
								<p><b><?php echo $lang['T_FROM']; ?> </b>01:01:2001 <b><?php echo $lang['T_TO']; ?></b> 02:02:2002 </p>
								<p><b><?php echo $lang['T_Content']; ?> : </b></p>
							</div>
						</div>
						
						<div class="panel panel-primary">
							<div class="panel-heading">La tâche</div>
							<div class="panel-body">
								<p><b><?php echo $lang['T_FROM']; ?> </b>01:01:2001 <b><?php echo $lang['T_TO']; ?></b> 02:02:2002 </p>
								<p><b><?php echo $lang['T_Content']; ?> : </b></p>
							</div>
						</div>
						
						<div class="panel panel-primary">
							<div class="panel-heading">La tâche</div>
							<div class="panel-body">
								<p><b><?php echo $lang['T_FROM']; ?> </b>01:01:2001 <b><?php echo $lang['T_TO']; ?></b> 02:02:2002 </p>
								<p><b><?php echo $lang['T_Content']; ?> : </b></p>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</body>
</html>			


