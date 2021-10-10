<!DOCTYPE html>
<html lang="fr">
<head>
	<title><?php echo $this->tab['title'] ?></title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="skin/poems.css" />
</head>
<body>
	<nav class="menu">
		<ul>
<?php
	foreach ($this->tab['menu'] as $text => $link) {
		echo "<li><a href=\"$link\">$text</a></li>";
	}
?>
		</ul>
	</nav>
	<main>
		<strong><?php $flash = key_exists('flash',$this->tab)?$this->tab['flash']:null; echo $flash;?></strong>
		<?php $form = $this->tab['connexion']?$this->tab['form_cnx']:$this->tab['logout_btn']; echo $form;?>
		<h1><?php echo $this->tab['title']; ?></h1>
		<?php echo $this->tab['content']; ?>
	</main>
</body>
</html>
