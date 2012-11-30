<?php include 'cnx.php';?>
<?php include 'functions.php';?>
<?php
if (isset($_SESSION['id_entity'])) {
	$qryEntity_main = "SELECT * FROM entities WHERE id = ".$_SESSION['id_entity'].";";
	$rstEntity_main = mysql_query($qryEntity_main);
	$rowEntity_main = mysql_fetch_array($rstEntity_main);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>:: ISIVEN <?=$title?> ::</title>
		<link rel=StyleSheet href="lib/css/style.css" type="text/css" media=screen />
	</head>
	<body>
		<?php
		if (isset($_SESSION['id_entity'])) {
		?>
			<div class="menu">
				<div class="col" style="border: none;">
					<ul class="horizontal">
						<li><a href="main.php">Principal</a></li>
						<li><a href="pages.php">Nueva P&aacute;gina</a></li>
						<li><a href="module_index.php">Módulo Inicio</a></li>
						<li><a href="indicators.php">Indicadores</a></li>
						<li><a href="customers.php">Clientes</a></li>
						<li><a href="projects.php">Proyectos</a></li>
					</ul>
				</div>
				<div class="col" align="right" style="border: none;">
					<ul class="nav-menu nav-right">
						<li>
							<a href="#"><span style="color: #00ffff;">Hola</span> <span style="color: #FFFFFF;"><?=utf8_decode($rowEntity_main['fname'])?> <?=utf8_decode($rowEntity_main['lname'])?></span> <img src="../files/imgs/<?=$rowEntity_main['image']?>" height="30" style="vertical-align: middle;" /></a>
							<ul>
								<!--li><a href="close_session.php">Editar Perfíl</a></li-->
								<li><a href="close_session.php">Cerrar Sesión</a></li>
							</ul>
						</li>
					</ul>
				</div>
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