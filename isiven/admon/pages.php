<?php
session_start();

if (isset($_SESSION['id_entity'])) {
	$title = "P&aacute;ginas";
	$body = "pages_body.php";
	include 'template.php';	
}else echo '<script>window.location = "./"</script>';