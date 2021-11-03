<!DOCTYPE html>
<html lang="fr">
<head>
	<title><?php echo $this->tab['title'] ?></title>
	<meta charset="UTF-8" />
	<meta name="Content-Language" content="en">
	<meta name="Subject" content="Gallerie des images">
	<meta name="Author" content="21911226">
	<!-- Facebook Open Graph -->
	<meta property="og:url"                content="?" />
	<meta property="og:type"               content="website" />
	<meta property="og:title"              content="Find out the most awesome picture and their stories" />
	<meta property="og:description"        content="Our website is about posting pictures and their stories in aim of sharing with people around the world some moments or events that we find special" />
	<meta property="og:image"              content="https://img.jakpost.net/c/2020/07/08/2020_07_08_99729_1594186791._large.jpg" />
	<meta property="og:locale"             content="en_US" />
	<!-- <link rel="stylesheet" href="skin/poems.css" /> -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
<!-- position-sticky -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark " role="navigation" style='top:0;'>
		<div class="container">
			<a class="navbar-brand" href="?">Gallery</a>
			<button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
				&#9776;
			</button>
			<div class="collapse navbar-collapse" id="exCollapsingNavbar">
				<ul class="nav navbar-nav">
					<?php
						foreach ($this->tab['menu'] as $text => $link) {
							echo "<li class='nav-item'><a href=\"$link\" class='nav-link'>$text</a></li>";
						}
					?>
				</ul>
				<ul class="nav navbar-nav flex-row justify-content-between ml-auto">
				<li class="nav-item order-2 order-md-1"><a href="#" class="nav-link" title="settings"><i class="fa fa-cog fa-fw fa-lg"></i></a></li>
					<li class="dropdown order-1">
						<?php $form = $this->tab['connexion']?$this->tab['form_cnx']:$this->tab['logout_btn']; echo $form;?>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<main >
		<div class="container">
			<strong><?php $flash = key_exists('flash',$this->tab)?$this->tab['flash']:null; echo $flash;?></strong>
			
			<h1><?php echo $this->tab['title']; ?></h1>
			<?php echo $this->tab['content']; ?>
		</div>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
