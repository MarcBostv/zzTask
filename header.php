<html>
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
					<li <?php if ($selected == "accueil") echo 'class="active"' ?>><a href="accueil.php"><?php echo $lang['ALL_TASKS']; ?></a></li>
					<li <?php if ($selected == "nouvelleTache") echo 'class="active"' ?>><a href="nouvelleTache.php"><?php echo $lang['CREATE_TASK']; ?></a></li>
					<?php
						if(strcmp($_SESSION['id'], "david") == 0){
					?>
							<li <?php if ($selected == "nouvelUtilisateur") echo 'class="active"' ?>><a href="nouvelUtilisateur.php"><?php echo $lang['CREATE_USER']; ?></a></li>
					<?php
						}
					?>
					
	      		</ul>
	      		<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $lang['LANG'];?><span class="caret"></span></a>
	       				<ul class="dropdown-menu">
							<li><a href="<?php echo $selected ?>.php?lang=fr">Fr</a></li>
							<li><a href="<?php echo $selected ?>.php?lang=en">En</a></li>
	       				</ul>
	       			</li>
					<li><a href="<?php echo $selected ?>.php?action=deco"><?php echo $lang['LOGOUT'];?></a></li>
	   			</ul>
	   		</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</html>
