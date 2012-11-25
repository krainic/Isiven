<?php
	session_start();
	if(isset($_REQUEST['id_entity'])){
		$_REQUEST['id_entity'] = NULL;
	}
    session_unset();
	session_destroy();
	header("Location: ./");