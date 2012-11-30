<?php
session_start();

if (isset($_SESSION['id_entity'])) {
	$title = "Clientes";
	$body = "customers_body.php";
	include 'template.php';	
}else echo '<script>window.location = "./"</script>';