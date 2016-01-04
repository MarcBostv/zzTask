<!-- > Tout d'abord on vérifie que nous sommes bien connectés <-->
<?php
	require('fonctions.php');
	controleSession();
	
	if(isset($_GET['action']) && $_GET['action'] == 'deco')
	{
		deconnexion();
		return;
	}
	
	if(isset($_POST['nomTask']) && isset($_POST['debut']) && isset($_POST['fin']) && isset($_POST['description']))
	{
		creationTask();
		return;
	}

	if(isset($_GET['lang']))
	{
	    $_SESSION['lang']=$_GET['lang'];
  	}

	include_once controleLang();
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



		<!-- > Texte d'explication <-->	
		<nav class="navbar navbar-default">
	  		<div class="container-fluid">
    			<!-- Brand and toggle get grouped for better mobile display -->
    			<div class="navbar-header">
      				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        				<span class="sr-only">Toggle navigation</span>
        				<span class="icon-bar"></span>
        				<span class="icon-bar"></span>
        				<span class="icon-bar"></span>
      				</button>
      				<a class="navbar-brand" href="accueil.php"><?php echo $lang['HEADER_TITLE']; ?></a>
    			</div>

    			<!-- Collect the nav links, forms, and other content for toggling -->
    			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      				<ul class="nav navbar-nav">
       					<li><a href="accueil.php"><?php echo $lang['ALL_TASKS']; ?></a></li>
        				<li class="active"><a href="nouvelleTache.php"><?php echo $lang['CREATE_TASK']; ?><span class="sr-only">(current)</span></a></li>
        				</li>
      				</ul>
      				<form class="navbar-form navbar-left" role="search">
        				<div class="form-group">
          					<input type="text" class="form-control" placeholder="Search">
        				</div>
        				<button type="submit" class="btn btn-default">Submit</button>
      				</form>
      				<ul class="nav navbar-nav navbar-right">
      					<li class="dropdown">
          					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $lang['LANG'];?><span class="caret"></span></a>
          					<ul class="dropdown-menu">
                     			<li><a href="nouvelleTache.php?lang=fr">Fr</a></li>
                      			<li><a href="nouvelleTache.php?lang=en">En</a></li>
          					</ul>
        				</li>
        				<li><a href="accueil.php?action=deco"><?php echo $lang['LOGOUT'];?></a></li>
      				</ul>
    			</div><!-- /.navbar-collapse -->
  			</div><!-- /.container-fluid -->
		</nav>
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


