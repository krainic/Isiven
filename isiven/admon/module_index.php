<?php
session_start();

if (isset($_SESSION['id_entity'])) {
	$title = "Módulo de Inicio";
	$body = "module_index_body.php";
	include 'template.php';	
}else echo '<script>window.location = "./"</script>';