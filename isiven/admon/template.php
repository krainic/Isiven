<?php include 'cnx.php';?>
<?php include 'functions.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>:: ISIVEN <?=$title?>::</title>
		<link rel=StyleSheet href="lib/css/style.css" type="text/css" media=screen />
	</head>
	<body>
		<?php
		if (isset($_SESSION['id_entity'])) {
		?>
			<div class="menu">
				<ul class="horizontal">
					<li><a href="main.php">Principal</a></li>
					<li><a href="pages.php">P&aacute;ginas</a></li>
					<li><a href="close_session.php">Cerrar Sesión</a></li>
				</ul>
			</div>
		<?php	
		}
		?>
		<div style="padding: 2em;" align="center"><img src="http://isiven.krainic.com/files/imgs/logo.png" /></div>
		<fieldset id="content">
			<legend align="right"><?=$title?></legend>
			<div>
				<?php include $body?>
			</div>
		</fieldset>
	</body>
</html>