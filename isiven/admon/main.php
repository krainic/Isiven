<?php
session_start();

if (isset($_SESSION['id_entity'])) {
	$title = "Principal";
	$body = "main_body.php";
	include 'template.php';
}else echo '<script>window.location = "./"</script>';