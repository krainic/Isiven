<?php
session_start();

if (isset($_SESSION['id_entity'])) {
	$title = "Proyectos";
	$body = "projects_body.php";
	include 'template.php';	
}else echo '<script>window.location = "./"</script>';